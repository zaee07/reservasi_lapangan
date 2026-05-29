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
        $tanggal = $this->input->get('tanggal');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $data = [
            'title'      => 'Booking',
            'active'     => 'booking',
            'main_view'  => 'user/booking/index',
            'tanggal'    => $tanggal,
            'jadwal'     => $this->booking->get_slot_tersedia($tanggal)
        ];
        // var_dump($data['jadwal']['GOR Harmoni Kutamendala']);
        // var_dump($data['jadwal']['GOR Harmoni Kutamendala']['lapangan 2']);
        // die();

        $this->load->view('templates/user_header', $data);
    }

    public function proses_1jam($jadwal_slot_id)
    {
        $slot = $this->booking->get_slot_by_id($jadwal_slot_id);

        if (!$slot) {
            show_404();
        }
        $cabang = $this->cabang->get_by_id($slot->cabang_id);

        if ($slot->status_slot != STATUS_SLOT_AVAILABLE) {

            $this->session->set_flashdata(
                'error',
                'Slot tidak tersedia'
            );

            redirect('booking');
        }

        $kode_booking = 'RSV' . strtoupper($cabang->kode_cabang) . '-' . date('YmdHis') . '-' . rand(10, 99);

        $durasi_menit = 60;

        $harga = 20000;

        $booking = [
            'cabang_id'            => $slot->cabang_id,
            'lapangan_id'          => $slot->lapangan_id,
            'user_id'              => $this->session->userdata('user_id'),
            'kode_booking'         => $kode_booking,
            'tipe_booking'         => BOOKING_TYPE_ONLINE,
            'nama_pemesan'         => $this->session->userdata('nama'),
            'no_hp_pemesan'        => $this->session->userdata('no_hp'),
            'tanggal_main'         => $slot->tanggal,
            'jam_mulai'            => $slot->jam_mulai,
            'jam_selesai'          => $slot->jam_selesai,
            'durasi_menit'         => $durasi_menit,
            'biaya_lapangan'       => $harga,
            'subtotal'             => $harga,
            'biaya_admin'          => 0,
            'total_bayar'          => $harga,
            'bonus_kok'            => 1,
            'status_booking'       => STATUS_BOOKING_PENDING,
            'expired_at'           => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];

        $this->db->trans_start();
        $booking_id = $this->booking->insert_booking($booking);

        $booking_slot = [
            'booking_id'       => $booking_id,
            'jadwal_slot_id'   => $slot->id,
            'harga'            => $harga
        ];

        $this->booking->insert_booking_slot($booking_slot);

        // update slot
        // $this->booking->update_slot(
        //     $slot->id,
        //     ['status_slot' => STATUS_SLOT_BOOKED]
        // );
        // $updated = $this->booking->update_slot_available(
        //     $slot->id
        // );
        $updated = $this->booking->update_slot_available($slot->id);

        if (!$updated) {

            $this->db->trans_rollback();

            $this->session->set_flashdata(
                'error',
                'Slot sudah dibooking orang lain'
            );

            redirect('booking');
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->session->set_flashdata(
                'error',
                'Booking gagal'
            );

            redirect('booking');
        }

        $this->session->set_flashdata(
            'success',
            'Booking berhasil dibuat'
        );

        redirect('booking/sukses/' . $booking_id);
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
            // validasi slot masih tersedia
            if ($slot->status_slot != STATUS_SLOT_AVAILABLE) {
                $this->session->set_flashdata('error', 'Ada slot yang sudah dibooking');
                redirect('booking');
            }
            $slots[] = $slot;
        }

        // validasi minimal ada slot
        if (empty($slots)) {
            $this->session->set_flashdata('error', 'Slot tidak valid');
            redirect('booking');
        }

        // validasi semua lapangan sama
        $lapangan_id = $slots[0]->lapangan_id;

        foreach ($slots as $slot) {
            if ($slot->lapangan_id != $lapangan_id) {
                $this->session->set_flashdata('error', 'Slot harus dari lapangan yang sama');
                redirect('booking');
            }
        }

        // urutkan slot
        usort($slots, function ($a, $b) {
            return strtotime($a->jam_mulai) - strtotime($b->jam_mulai);
        });

        // validasi slot berurutan
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]->jam_selesai  != $slots[$i + 1]->jam_mulai) {
                $this->session->set_flashdata('error', 'Slot harus berurutan');
                redirect('booking');
            }
        }

        $first_slot = $slots[0];
        $last_slot  = end($slots);

        $cabang = $this->cabang->get_by_id($first_slot->cabang_id);
        $kode_booking = 'RSV-' . strtoupper($cabang->kode_cabang) . '-' . date('Ymd-His') . '-' . rand(10, 99);
        $harga_perjam = 20000;
        $jumlah_slot = count($slots);
        $total = $harga_perjam * $jumlah_slot;
        $durasi_menit = $jumlah_slot * 60;

        $booking = [
            'cabang_id'      => $first_slot->cabang_id,
            'lapangan_id'    => $first_slot->lapangan_id,
            'user_id'        => $this->session->userdata('user_id'),
            'kode_booking'   => $kode_booking,
            'tipe_booking'   => BOOKING_TYPE_ONLINE,
            'nama_pemesan'   => $this->session->userdata('nama'),
            'no_hp_pemesan'  => $this->session->userdata('no_hp'),
            'tanggal_main'   => $first_slot->tanggal,
            'jam_mulai'      => $first_slot->jam_mulai,
            'jam_selesai'    => $last_slot->jam_selesai,
            'durasi_menit'   => $durasi_menit,
            'biaya_lapangan' => $total,
            'subtotal'       => $total,
            'biaya_admin'    => 0,
            'total_bayar'    => $total,
            'bonus_kok'      => $jumlah_slot,
            'status_booking' => STATUS_BOOKING_PENDING,
            'expired_at'     => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];

        $this->db->trans_start();

        $booking_id = $this->booking->insert_booking($booking);

        foreach ($slots as $slot) {
            // insert booking slot
            $this->booking->insert_booking_slot([
                'booking_id'     => $booking_id,
                'jadwal_slot_id' => $slot->id,
                'harga'          => $harga_perjam
            ]);

            // lock slot
            $updated = $this->booking->update_slot_available($slot->id);

            if (!$updated) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Ada slot yang sudah dibooking orang lain');
                redirect('booking');
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Booking gagal');
            redirect('booking');
        }

        $this->session->set_flashdata('success', 'Booking berhasil dibuat');
        redirect('booking/sukses/' . $booking_id);
    }


    public function sukses($booking_id)
    {
        $booking = $this->booking
            ->get_booking_by_id($booking_id);

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
