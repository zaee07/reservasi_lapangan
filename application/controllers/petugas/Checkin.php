<?php
require_once APPPATH . 'core/Petugas_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Checkin extends Petugas_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Booking_model', 'booking');
    }

    public function index()
    {
        $data = [
            'title' => 'Scan QR',
            'active' => 'checkin',
            'main_view' => 'petugas/checkin/index'
        ];

        $this->load->view('templates/header', $data);
    }

    private function json_response($status, $message, $data = [])
    {
        return $this->output->set_output(
            json_encode(array_merge(['status'  => $status, 'message' => $message], $data))
        );
    }

    private function validate_booking($booking)
    {
        if (!$booking) {
            return 'Booking tidak ditemukan';
        }

        if ($booking->cabang_id != $this->user['cabang_id']) {
            return 'Booking cabang lain';
        }

        if ($booking->status_booking == STATUS_BOOKING_CHECKIN) {
            return 'Booking sudah check-in';
        }

        if ($booking->status_booking != STATUS_BOOKING_CONFIRMED) {
            return 'Booking belum valid';
        }

        if ($booking->status_pembayaran != STATUS_PEMBAYARAN_PAID) {
            return 'Belum dibayar';
        }

        return true;
    }

    public function proses()
    {
        $this->output->set_content_type('application/json');
        $qr = $this->input->post('qr_data');
        list($booking_id, $kode_booking) = explode('|', $qr);
        $booking = $this->booking->get_booking_by_id_and_code($booking_id, $kode_booking);
        $valid = $this->validate_booking($booking);

        if ($valid !== true) {
            return $this->json_response(false, $valid);
        }

        $this->db->trans_start();
        $this->booking->checkin($booking->id);
        $this->db->trans_complete();
        return $this->output->set_output(json_encode([
            'status' => true,
            'message' => 'Check-in berhasil',
            'booking' => [
                'kode_booking'  => $booking->kode_booking,
                'nama_pemesan'  => $booking->nama_pemesan,
                'nama_lapangan' => $booking->nama_lapangan
            ]
        ]));
    }
}
