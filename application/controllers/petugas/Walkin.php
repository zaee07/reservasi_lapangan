<?php
require_once APPPATH . 'core/Petugas_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Walkin extends Petugas_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Cabang_model', 'cabang');
        $this->load->model('Lapangan_model', 'lapangan');
        $this->load->model('booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
    }

    public function index()
    {
        $data = [
            'title'     => 'Booking Walk In',
            'active'    => 'walkin',
            'main_view' => 'petugas/walkin/index',
            'slot_tersedia' => $this->booking->get_slot_tersedia(date('Y-m-d'), $this->user['cabang_id'])
        ];
        $this->load->view('templates/header', $data);
    }

    public function search_member()
    {
        $keyword = $this->input->get('q');
        $members = $this->pengguna->search_member($keyword);
        $result = [];
        foreach ($members as $member) {
            $result[] = [
                'id' => $member->id,
                'text' => $member->nama . ' | ' . $member->no_hp,
                'no_hp' => $member->no_hp,
                'email' => $member->email
            ];
        }
        echo json_encode($result);
    }

    public function simpan()
    {
        $tipe = $this->input->post('tipe_pemesan');
        $slot_ids = $this->input->post('slot_ids');
        if (!$slot_ids) {
            $this->session->set_flashdata('error', 'Pilih minimal 1 slot');
            redirect('walkin');
        }

        $slots = [];
        foreach ($slot_ids as $slot_id) {
            $slot = $this->booking->get_slot_by_id($slot_id);
            if (!$slot) {
                continue;
            }
            if ($slot->status_slot != STATUS_SLOT_AVAILABLE) {
                $this->session->set_flashdata('error', 'Ada slot yang sudah dibooking');
                redirect('walkin');
            }
            $slots[] = $slot;
        }

        if (empty($slots)) {
            $this->session->set_flashdata('error', 'Slot tidak valid');
            redirect('walkin');
        }
        $lapangan_id = $slots[0]->lapangan_id;
        foreach ($slots as $slot) {
            if ($slot->lapangan_id != $lapangan_id) {
                $this->session->set_flashdata('error', 'Slot harus dari lapangan yang sama');
                redirect('walkin');
            }
        }
        usort($slots, function ($a, $b) {
            return strtotime($a->jam_mulai) - strtotime($b->jam_mulai);
        });
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]->jam_selesai != $slots[$i + 1]->jam_mulai) {
                $this->session->set_flashdata('error', 'Slot harus berurutan');
                redirect('walkin');
            }
        }

        $first_slot = $slots[0];
        $last_slot  = end($slots);
        $cabang = $this->cabang->get_by_id($this->user['cabang_id']);
        if ($first_slot->cabang_id != $this->user['cabang_id']) {
            show_error('Akses ditolak');
        }
        /**
         * jadwal yg tampil dan bisa dipilih hanya jadwal dari cabang si petugas
         * harga member 20000 (bonus 1 kok perslot)
         * harga non member 25000 (tanpa bonus kok)
         */
        if (!in_array($tipe, ['member', 'non_member'])) {
            show_error('Request tidak valid');
        }
        if ($tipe == 'member') {
            $user_id = $this->input->post('user_id');
            if (!$user_id) {
                $this->session->set_flashdata('error', 'Silakan pilih member');
                redirect('walkin');
            }
            $member = $this->pengguna->get_by_id($user_id);
            if (!$member) {
                $this->session->set_flashdata('error', 'Member tidak ditemukan');
                redirect('walkin');
            }
        }
        if ($tipe == 'non_member') {
            $nama_pemesan = trim($this->input->post('nama_pemesan'));
            $no_hp_pemesan = trim($this->input->post('no_hp_pemesan'));
            if (empty($nama_pemesan)) {
                $this->session->set_flashdata('error', 'Nama pemesan wajib diisi');
                redirect('walkin');
            }
            if (empty($no_hp_pemesan)) {
                $this->session->set_flashdata('error', 'No HP wajib diisi');
                redirect('walkin');
            }
            if (!preg_match('/^[0-9]{10,15}$/', $no_hp_pemesan)) {
                $this->session->set_flashdata('error', 'Format No HP tidak valid');
                redirect('walkin');
            }
        }
        $harga_perjam = $tipe == 'member' ? 20000 : 25000;
        $jumlah_slot  = count($slots);
        $subtotal     = $harga_perjam * $jumlah_slot;
        $biaya_admin  = 0;
        $total_bayar  = $subtotal + $biaya_admin;
        $durasi_menit = $jumlah_slot * 60;
        $kode_booking = 'WLK-' . strtoupper($cabang->kode_cabang) . '-' . date('YmdHis') . rand(10, 99);
        $invoice_no = 'INVWLK-' . strtoupper($cabang->kode_cabang) . '-' . date('YmdHis') . rand(10, 99);
        $booking = [
            'cabang_id' => $first_slot->cabang_id,
            'lapangan_id' => $first_slot->lapangan_id,
            'user_id' => $tipe == 'member' ? $member['id'] : null,
            'dibuat_oleh_user_id' => $this->user['id'],
            'kode_booking' => $kode_booking,
            'tipe_booking' => BOOKING_TYPE_OFFLINE,
            'nama_pemesan' => $tipe == 'member' ? $member['nama'] : $this->input->post('nama_pemesan'),
            'no_hp_pemesan' => $tipe == 'member' ? $member['no_hp'] : $this->input->post('no_hp_pemesan'),
            'tanggal_main' => $first_slot->tanggal,
            'jam_mulai' => $first_slot->jam_mulai,
            'jam_selesai' => $last_slot->jam_selesai,
            'durasi_menit' => $durasi_menit,
            'biaya_lapangan' => $subtotal,
            'subtotal' => $subtotal,
            'biaya_admin' => $biaya_admin,
            'total_bayar' => $total_bayar,
            'bonus_kok' => $tipe == 'member' ? $jumlah_slot : 0,
            'status_booking' => STATUS_BOOKING_CHECKIN,
            'confirmed_at' => date('Y-m-d H:i:s'),
            'checked_in_at' => date('Y-m-d H:i:s')
        ];
        $this->db->trans_begin();
        $booking_id = $this->booking->insert_booking($booking);
        if (!$booking_id) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Booking gagal dibuat');
            redirect('walkin');
        }
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
                redirect('walkin');
            }
        }
        $pembayaran = [
            'booking_id' => $booking_id,
            'invoice_no' => $invoice_no,
            'metode_bayar' => 'cash',
            'nominal' => $total_bayar,
            'status_pembayaran' => STATUS_PEMBAYARAN_PAID,
            'paid_at' => date('Y-m-d H:i:s')
        ];
        $pembayaran_id = $this->pembayaran->insert($pembayaran);
        if (!$pembayaran_id) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Pembayaran gagal dibuat');
            redirect('walkin');
        }
        $this->booking->insert_status_history([
            'booking_id' => $booking_id,
            'status_booking' => STATUS_BOOKING_CONFIRMED,
            'keterangan' => 'Booking Walk In',
            'diubah_oleh_user_id' => $this->user['id']
        ]);
        $this->booking->insert_status_history([
            'booking_id' => $booking_id,
            'status_booking' => STATUS_BOOKING_CHECKIN,
            'keterangan' => 'Booking Walk In',
            'diubah_oleh_user_id' => $this->user['id']
        ]);
        $this->pembayaran->insert_riwayat_pembayaran([
            'pembayaran_id'      => $pembayaran_id,
            'status_pembayaran'  => STATUS_PEMBAYARAN_PAID,
            'keterangan'         => 'Pembayaran Cash'
        ]);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Booking gagal');
            redirect('walkin');
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('success', 'Booking Walk In berhasil');
        redirect('petugas/walkin');
    }
}
