<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model', 'booking');
        $this->load->model('Cabang_model', 'cabang');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
        $kode_cabang = $this->input->get('kode_cabang');
        $cabang = $this->cabang->get_all();
        if (!$kode_cabang && !empty($cabang)) {
            $kode_cabang = $cabang[0]->kode_cabang;
        }
        $data = [
            'title'      => 'Booking',
            'active'     => 'booking',
            'main_view'  => 'user/booking/index',
            'tanggal'    => $tanggal,
            'kode_cabang' => $kode_cabang,
            'cabang'      => $cabang,
            'jadwal'     => $this->booking->get_slot_tersedia($tanggal, $kode_cabang)
        ];
        $this->load->view('templates/user_header', $data);
    }

    public function proses()
    {
        $slot_ids = $this->input->post('slot_id');

        if (!$slot_ids) {
            $this->session->set_flashdata('error', 'Pilih minimal 1 slot');
            redirect('booking');
        }

        $slots = [];
        foreach ($slot_ids as $slot_id) {
            $slot = $this->booking->get_slot_by_id($slot_id);
            if (!$slot) {
                continue;
            }
            if ($slot->status_slot != STATUS_SLOT_AVAILABLE) {
                $this->session->set_flashdata('error', 'Ada slot yang sudah dibooking');
                redirect('booking');
            }
            $slots[] = $slot;
        }

        if (empty($slots)) {
            $this->session->set_flashdata('error', 'Slot tidak valid');
            redirect('booking');
        }
        $lapangan_id = $slots[0]->lapangan_id;
        foreach ($slots as $slot) {
            if ($slot->lapangan_id != $lapangan_id) {
                $this->session->set_flashdata('error', 'Slot harus dari lapangan yang sama');
                redirect('booking');
            }
        }
        usort($slots, function ($a, $b) {
            return strtotime($a->jam_mulai) - strtotime($b->jam_mulai);
        });
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]->jam_selesai != $slots[$i + 1]->jam_mulai) {
                $this->session->set_flashdata('error', 'Slot harus berurutan');
                redirect('booking');
            }
        }
        $first_slot = $slots[0];
        $last_slot  = end($slots);
        $cabang = $this->cabang->get_by_id($first_slot->cabang_id);
        if ($this->booking->has_pending_booking($this->user['id'])) {
            $this->session->set_flashdata('error', 'Selesaikan pembayaran booking sebelumnya terlebih dahulu');
            redirect('booking');
        }
        $harga_perjam = 20000;
        $jumlah_slot  = count($slots);
        $subtotal     = $harga_perjam * $jumlah_slot;
        $biaya_admin  = 0;
        $total_bayar  = $subtotal + $biaya_admin;
        $durasi_menit = $jumlah_slot * 60;
        $kode_booking = 'RSV-' . strtoupper($cabang->kode_cabang) . '-' . date('YmdHis') . rand(10, 99);
        $invoice_no = 'INV-' . strtoupper($cabang->kode_cabang) . '-' . date('YmdHis') . rand(10, 99);

        $booking = [
            'cabang_id'       => $first_slot->cabang_id,
            'lapangan_id'     => $first_slot->lapangan_id,
            'user_id'         => $this->user['id'],
            'kode_booking'    => $kode_booking,
            'tipe_booking'    => BOOKING_TYPE_ONLINE,
            'nama_pemesan'    => $this->user['nama'],
            'no_hp_pemesan'   => $this->user['no_hp'],
            'tanggal_main'    => $first_slot->tanggal,
            'jam_mulai'       => $first_slot->jam_mulai,
            'jam_selesai'     => $last_slot->jam_selesai,
            'durasi_menit'    => $durasi_menit,
            'biaya_lapangan'  => $subtotal,
            'subtotal'        => $subtotal,
            'biaya_admin'     => $biaya_admin,
            'total_bayar'     => $total_bayar,
            'bonus_kok'       => $jumlah_slot,
            'status_booking'  => STATUS_BOOKING_PENDING,
            'expired_at'      => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ];

        $this->db->trans_begin();
        $booking_id = $this->booking->insert_booking($booking);
        if (!$booking_id) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Booking gagal dibuat');
            redirect('booking');
        }
        $this->booking->insert_status_history([
            'booking_id'         => $booking_id,
            'status_booking'     => STATUS_BOOKING_PENDING,
            'keterangan'         => 'Booking dibuat member',
            'diubah_oleh_user_id' => $this->user['id']
        ]);
        foreach ($slots as $slot) {
            $this->booking->insert_booking_slot([
                'booking_id'      => $booking_id,
                'jadwal_slot_id'  => $slot->id,
                'harga'           => $harga_perjam
            ]);
            $updated = $this->booking->update_slot_available($slot->id);
            if (!$updated) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Slot sudah dibooking orang lain');
                redirect('booking');
            }
        }
        $pembayaran = [
            'booking_id'          => $booking_id,
            'invoice_no'          => $invoice_no,
            'metode_bayar'        => 'qris',
            'nominal'             => $total_bayar,
            'status_pembayaran'   => STATUS_PEMBAYARAN_UNPAID,
            'expired_at'          => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ];
        $this->db->insert('pembayaran', $pembayaran);
        $pembayaran_id = $this->db->insert_id();
        if (!$pembayaran_id) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Pembayaran gagal dibuat');
            redirect('booking');
        }
        $this->db->insert(
            'riwayat_status_pembayaran',
            [
                'pembayaran_id'      => $pembayaran_id,
                'status_pembayaran'  => STATUS_PEMBAYARAN_UNPAID,
                'keterangan'         => 'Menunggu Pembayaran'
            ]
        );
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Booking gagal');
            redirect('booking');
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('success', 'Booking berhasil dibuat');
        redirect('booking/sukses/' . $booking_id);
    }

    public function sukses($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);
        if (!$booking) {
            show_404();
        }
        $data = [
            'title'      => 'Booking Berhasil',
            'active'     => 'booking',
            'main_view'  => 'user/booking/success',
            'booking'    => $booking
        ];
        $this->load->view('templates/user_header', $data);
    }
}
