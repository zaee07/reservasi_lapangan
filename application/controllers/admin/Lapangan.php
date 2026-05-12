<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Lapangan extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Lapangan_model', 'lapangan');
        $this->load->model('Pengguna_model', 'pengguna');
    }

    public function index()
    {
        // $anjay = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;
        // var_dump($anjay);
        // die();
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $data = [
            'title'     => 'Lapangan',
            'main_view' => 'admin/lapangan/index',
            'lapangan'  => $this->lapangan->get_by_cabang($cabang_id)
        ];

        $this->load->view('templates/header', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Lapangan';
        $data['main_view'] = 'admin/lapangan/create';

        $this->load->view('templates/header', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules(
            'kode_lapangan',
            'Kode Lapangan',
            // 'required'
        );

        $this->form_validation->set_rules(
            'nama_lapangan',
            'Nama Lapangan',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $this->create();
        } else {

            $foto = null;

            if (!empty($_FILES['foto']['name'])) {

                $config['upload_path']   = './uploads/lapangan/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {

                    $upload = $this->upload->data();
                    $foto = $upload['file_name'];
                }
            }

            $anjay = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;
            // var_dump($anjay);
            // die();
            $data = [
                'cabang_id'      => $anjay,
                // 'kode_lapangan'  => htmlspecialchars($this->input->post('kode_lapangan', true)),
                'nama_lapangan'  => htmlspecialchars($this->input->post('nama_lapangan', true)),
                'jenis_lantai'   => $this->input->post('jenis_lantai'),
                'foto'           => $foto,
                'status'         => $this->input->post('status')
            ];

            $this->lapangan->insert($data);

            $this->session->set_flashdata(
                'success',
                'Lapangan berhasil ditambahkan'
            );

            redirect('lapangan');
        }
    }

    public function edit($id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $lapangan = $this->lapangan->get_by_id($id);

        // validasi milik cabang
        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }

        $data = [
            'title'     => 'Edit Lapangan',
            'main_view' => 'admin/lapangan/edit',
            'lapangan'  => $lapangan
        ];

        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }

        $foto = $lapangan->foto;

        if (!empty($_FILES['foto']['name'])) {

            $config['upload_path']   = './uploads/lapangan/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {

                if ($foto && file_exists('./uploads/lapangan/' . $foto)) {
                    unlink('./uploads/lapangan/' . $foto);
                }

                $upload = $this->upload->data();
                $foto = $upload['file_name'];
            }
        }

        $data = [
            // 'kode_lapangan' => htmlspecialchars($this->input->post('kode_lapangan', true)),
            'nama_lapangan' => htmlspecialchars($this->input->post('nama_lapangan', true)),
            'jenis_lantai'  => $this->input->post('jenis_lantai'),
            'status'        => $this->input->post('status'),
            'foto'          => $foto
        ];

        $this->lapangan->update($id, $data);

        $this->session->set_flashdata(
            'success',
            'Lapangan berhasil diupdate'
        );

        redirect('lapangan');
    }

    public function delete($id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->session->userdata('id'))->cabang_id;

        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }

        if (
            $lapangan->foto &&
            file_exists('./uploads/lapangan/' . $lapangan->foto)
        ) {

            unlink('./uploads/lapangan/' . $lapangan->foto);
        }

        $this->lapangan->delete($id);

        $this->session->set_flashdata(
            'success',
            'Lapangan berhasil dihapus'
        );

        redirect('lapangan');
    }
}
