<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        // $this->load->model('Lapangan_model', 'lapangan');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Jadwal_model', 'jadwal');
        $this->load->library('form_validation');
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
            'main_view' => 'admin/jadwal/index',
            'tanggal'   => $tanggal,
            'lapangan'  => $this->jadwal->get_lapangan($this->user['cabang_id']),
            'jadwal'    => $this->jadwal->get_jadwal($this->user['cabang_id'], $tanggal, $lapangan)
        ];

        $this->load->view('templates/header', $data);
    }

    public function edit($id)
    {
        $jadwal = $this->jadwal->get_by_id($id);

        if (!$jadwal || $jadwal->cabang_id != $this->user['cabang_id']) {
            show_error('Akses ditolak!', 403);
        }
        if ($this->input->post('status') == STATUS_SLOT_BOOKED) {
            $this->session->set_flashdata('error', 'Status jadwal gagal diupdate/Slot sudah dibooking');
            redirect('jadwal?tanggal=' . $jadwal->tanggal);
        }

        $data = [
            'title' => 'Edit Status Jadwal',
            'main_view' => 'admin/jadwal/edit',
            'jadwal' => $jadwal
        ];

        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $jadwal = $this->jadwal->get_by_id($id);

        if (!$jadwal || $jadwal->cabang_id != $this->user['cabang_id']) {
            show_error('Akses ditolak!', 403);
        }
        if ($this->input->post('status') == STATUS_SLOT_BOOKED) {
            $this->session->set_flashdata('error', 'Status jadwal gagal diupdate/Slot sudah dibooking');
            redirect('jadwal?tanggal=' . $jadwal->tanggal);
        }

        $data = [
            'status_slot' => $this->input->post('status')
        ];

        $this->jadwal->update($id, $data);
        $this->session->set_flashdata('success', 'Status jadwal berhasil diupdate');

        redirect('jadwal?tanggal=' . $jadwal->tanggal);
    }
}
