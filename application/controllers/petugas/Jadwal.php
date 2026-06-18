<?php
require_once APPPATH . 'core/Petugas_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends Petugas_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model', 'jadwal');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $lapangan = $this->input->get('lapangan');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $data = [
            'title'     => 'Jadwal Slot',
            'active'    => 'jadwal',
            'main_view' => 'petugas/jadwal/index',
            'tanggal'   => $tanggal,
            'lapangan'  => $this->jadwal->get_lapangan($this->user['cabang_id']),
            'jadwal'    => $this->jadwal->get_jadwal($this->user['cabang_id'], $tanggal, $lapangan)
        ];

        $this->load->view('templates/header', $data);
    }
}
