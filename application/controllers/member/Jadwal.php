<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model', 'jadwal');
        $this->load->model('Cabang_model', 'cabang');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $kode_cabang = $this->input->get('kode_cabang');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }
        $cabang = $this->jadwal->get_cabang();
        if (!$kode_cabang && !empty($cabang)) {
            $kode_cabang = $cabang[0]->kode_cabang;
        }

        $data = [
            'title'       => 'Jadwal Lapangan',
            'active'      => 'jadwal',
            'main_view'   => 'user/jadwal/index',
            'tanggal'     => $tanggal,
            'kode_cabang' => $kode_cabang,
            'cabang'      => $cabang,
            'jadwal'      => $this->jadwal->get_jadwal_slot_by_tgl($tanggal, $kode_cabang) //get_jadwal_by_tgl($tanggal, $kode_cabang)
        ];

        $this->load->view('templates/user_header', $data);
    }
}
