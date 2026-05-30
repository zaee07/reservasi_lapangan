<?php
require_once APPPATH . 'core/Member_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(
            'Riwayat_model',
            'riwayat'
        );
    }

    public function index()
    {
        $user_id = $this->session
            ->userdata('user_id');

        $data = [

            'title'      => 'Riwayat Booking',
            'active'     => 'riwayat',
            'main_view'  => 'user/riwayat/index',

            'riwayat'    => $this->riwayat->get_by_user($user_id)

        ];

        $this->load->view(
            'templates/user_header',
            $data
        );
    }

    // detail booking
    public function detail($booking_id)
    {
        $user_id = $this->session
            ->userdata('user_id');

        $booking = $this->riwayat
            ->get_detail_booking(
                $booking_id,
                $user_id
            );

        if (!$booking) {
            show_404();
        }

        $data = [

            'title'      => 'Detail Booking',
            'active'     => 'riwayat',
            'main_view'  => 'user/riwayat/detail',

            'booking'    => $booking,

            'slots'      => $this->riwayat
                ->get_booking_slots($booking_id)

        ];

        $this->load->view(
            'templates/user_header',
            $data
        );
    }

    // cancel booking
    public function cancel($booking_id)
    {
        $user_id = $this->session
            ->userdata('user_id');

        $booking = $this->riwayat
            ->get_detail_booking(
                $booking_id,
                $user_id
            );

        if (!$booking) {
            show_404();
        }

        // hanya pending
        if (
            $booking->status_booking
            !=
            STATUS_BOOKING_PENDING
        ) {

            $this->session->set_flashdata(
                'error',
                'Booking tidak bisa dibatalkan'
            );

            redirect('riwayat');
        }

        $this->db->trans_start();

        // update booking
        $this->riwayat->update_booking(
            $booking_id,
            [
                'status_booking'
                =>
                STATUS_BOOKING_CANCELLED
            ]
        );
        $this->riwayat->insert_status_history([

            'booking_id'          => $booking_id,

            'status_booking'      => STATUS_BOOKING_CANCELLED,

            'keterangan'          => 'Booking dibatalkan member',

            'diubah_oleh_user_id' =>
            $this->session->userdata('user_id')

        ]);

        // buka slot lagi
        $this->riwayat
            ->release_slot($booking_id);

        $this->db->trans_complete();

        $this->session->set_flashdata(
            'success',
            'Booking berhasil dibatalkan'
        );

        redirect('riwayat');
    }
}
