<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Reservasi_model', 'reservasi');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');

        $status = $this->input
            ->get('status');

        if (!$tanggal) {

            $tanggal = date('Y-m-d');
        }

        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;;

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
}
