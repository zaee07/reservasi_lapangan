<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Reservasi_model', 'reservasi');
        $this->load->model('booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $status = $this->input->get('status');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $data = [
            'title'      => 'Riwayat Transaksi',
            'active'     => 'admin/transaksi',
            'main_view'  => 'admin/riwayat/index',
            'tanggal'    => $tanggal,
            'status'     => $status,
            'reservasi'  => $this->booking->get_booking($this->user['cabang_id'], $tanggal, $status)
        ];
        $this->load->view('templates/header', $data);
    }

    public function detail($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id, $this->user['cabang_id']);

        if (!$booking) {
            show_404();
        }

        $data = [
            'title'      => 'Detail Pembayaran',
            'active'     => 'admin/transaksi',
            'main_view'  => 'admin/riwayat/detail',
            'booking' => $booking,
            'slots'      => $this->reservasi->get_booking_slots($booking_id),
            'riwayat'    => $this->booking->get_riwayat_booking($booking_id),
            'riwayat_bayar' => $this->pembayaran->get_riwayat_status($booking->pembayaran_id)
        ];
        $this->load->view('templates/header', $data);
    }
}
