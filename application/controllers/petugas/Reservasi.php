<?php
require_once APPPATH . 'core/Petugas_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi extends Petugas_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Reservasi_model', 'reservasi');
        $this->load->model('Booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
        $this->load->model('Riwayat_model', 'riwayat');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $status = $this->input->get('status');
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;

        $data = [
            'title'      => 'Reservasi',
            'active'     => 'reservasi',
            'main_view'  =>
            'admin/reservasi/index',
            'tanggal'    => $tanggal,
            'status'     => $status,
            'reservasi'  =>
            $this->reservasi
                ->get_reservasi(
                    $cabang_id,
                    $tanggal,
                    $status
                )

        ];
        // var_dump($cabang_id);
        // var_dump($data['reservasi']);
        // die();

        $this->load->view(
            'templates/header',
            $data
        );
    }

    public function detail($booking_id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;
        $booking = $this->reservasi
            ->get_detail_booking(
                $booking_id,
                $cabang_id
            );

        if (!$booking) {
            show_404();
        }

        $data = [

            'title'      => 'Detail Reservasi',

            'active'     => 'reservasi',

            'main_view'  =>
            'admin/reservasi/detail',

            'booking'    => $booking,

            'slots'      =>
            $this->reservasi
                ->get_booking_slots(
                    $booking_id
                )

        ];

        $this->load->view(
            'templates/header',
            $data
        );
    }

    public function confirm($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);
        // var_dump($booking);
        // die();
        if (!$booking) {
            show_404();
        }
        if ($booking->status_booking != STATUS_BOOKING_PENDING) {
            $this->session->set_flashdata('error', 'Booking tidak valid');
            redirect('admin/reservasi');
        }

        $this->db->trans_start();
        // booking confirmed
        $this->booking->update_booking_status($booking_id, STATUS_BOOKING_CONFIRMED);

        // pembayaran paid
        $this->pembayaran->update_status_by_booking(
            $booking_id,
            [
                'status_pembayaran'
                =>
                STATUS_PEMBAYARAN_PAID,

                'paid_at'
                =>
                date('Y-m-d H:i:s')
            ]
        );

        $this->load->helper('qrcode');
        $qr_code = generate_booking_qr($booking_id, $booking->kode_booking);

        $this->booking->update_booking($booking_id, ['qr_booking' => $qr_code, 'confirmed_at' => date('Y-m-d H:i:s')]);

        // history booking
        $this->booking->insert_status_history([
            'booking_id'          => $booking_id,
            'status_booking'      => STATUS_BOOKING_CONFIRMED,
            'keterangan'          => 'Booking dikonfirmasi admin',
            'diubah_oleh_user_id' => $this->user['id']
        ]);
        // hisyory pembayaran
        $this->riwayat->insert_riwayat_pembayaran([
            'pembayaran_id'          => $booking->pembayaran_id,
            'status_pembayaran'      => STATUS_PEMBAYARAN_PAID,
            'keterangan'          => 'Booking dikonfirmasi admin'
        ]);

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Booking berhasil dikonfirmasi');

        redirect('admin/reservasi/detail/' . $booking_id);
    }
}
