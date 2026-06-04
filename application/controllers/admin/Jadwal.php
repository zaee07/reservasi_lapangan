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
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;
        $tanggal = $this->input->get('tanggal');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $data = [
            'title'     => 'Jadwal Slot',
            'main_view' => 'admin/jadwal/index',
            'tanggal'   => $tanggal,
            'jadwal'    => $this->jadwal
                ->get_jadwal($cabang_id, $tanggal)
        ];

        $this->load->view('templates/header', $data);
    }

    // form generate slot
    public function generate()
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $data = [
            'title'     => 'Generate Slot',
            'main_view' => 'admin/jadwal/generate',
            'lapangan'  => $this->jadwal
                ->get_lapangan($cabang_id)
        ];
        // var_dump($data['lapangan']);
        // die();

        $this->load->view('templates/header', $data);
    }

    public function store_generate()
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $lapangan_id   = $this->input->post('lapangan_id');
        $tanggal       = $this->input->post('tanggal');

        $jam_buka      = $this->input->post('jam_buka');
        $jam_tutup     = $this->input->post('jam_tutup');

        $start = strtotime($jam_buka);
        $end   = strtotime($jam_tutup);

        /*
        validasi jadwal slot pernah dibuat
        */

        while ($start < $end) {

            $jam_mulai = date('H:i:s', $start);

            $next = strtotime('+1 hour', $start);

            $jam_selesai = date('H:i:s', $next);

            // cek slot sudah ada
            $cek = $this->jadwal->cek_slot(
                $lapangan_id,
                $tanggal,
                $jam_mulai
            );

            if (!$cek) {

                $data = [
                    'cabang_id'   => $cabang_id,
                    'lapangan_id' => $lapangan_id,
                    'tanggal'     => $tanggal,
                    'jam_mulai'   => $jam_mulai,
                    'jam_selesai' => $jam_selesai,
                    'status_slot'      => 'available'
                ];

                $this->jadwal->insert($data);
            }

            $start = $next;
        }

        $this->session->set_flashdata(
            'success',
            'Slot jadwal berhasil digenerate'
        );

        redirect('jadwal?tanggal=' . $tanggal);
    }

    // edit status slot
    public function edit($id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;
        $jadwal = $this->jadwal->get_by_id($id);

        if (!$jadwal || $jadwal->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
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
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;
        $jadwal = $this->jadwal->get_by_id($id);

        if (!$jadwal || $jadwal->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }

        $data = [
            'status_slot' => $this->input->post('status')
        ];

        $this->jadwal->update($id, $data);

        $this->session->set_flashdata(
            'success',
            'Status jadwal berhasil diupdate'
        );

        redirect('jadwal?tanggal=' . $jadwal->tanggal);
    }
}
