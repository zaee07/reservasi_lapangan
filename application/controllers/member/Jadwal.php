<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model', 'jadwal');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $data = [
            'title'       => 'Jadwal Lapangan',
            'active'      => 'jadwal',
            'main_view'   => 'user/jadwal/index',
            'tanggal'     => $tanggal,
            'cabang'      => $this->jadwal->get_cabang(),
            'jadwal'      => $this->jadwal->get_jadwal_by_tgl($tanggal)
        ];

        $this->load->view('templates/user_header', $data);
    }
}
