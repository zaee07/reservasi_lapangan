<?php
require_once APPPATH . 'core/Owner_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends Owner_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cabang_model', 'cabang');
        // $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Cabang',
            'main_view' => 'owner/cabang/index',
            'cabang'  => $this->cabang->get_all()
        ];

        // $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar', $data);
        // $this->load->view('cabang/index', $data);
        // $this->load->view('templates/footer');
        $this->load->view('templates/header', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Cabang';
        $data['main_view'] = 'owner/cabang/create';

        $this->load->view('templates/header', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules(
            'kode_cabang',
            'Kode Cabang',
            'required|is_unique[cabang.kode_cabang]'
        );

        $this->form_validation->set_rules(
            'nama_cabang',
            'Nama Cabang',
            'required'
        );

        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $this->create();
        } else {

            $logo = null;

            // upload logo
            if (!empty($_FILES['logo']['name'])) {

                $config['upload_path']   = './uploads/logo/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo')) {

                    $upload = $this->upload->data();
                    $logo = $upload['file_name'];
                }
            }

            $data = [
                'kode_cabang' => htmlspecialchars($this->input->post('kode_cabang', true)),
                'nama_cabang' => htmlspecialchars($this->input->post('nama_cabang', true)),
                'alamat'      => htmlspecialchars($this->input->post('alamat', true)),
                'no_wa'       => htmlspecialchars($this->input->post('no_wa', true)),
                'logo'        => $logo,
                'status'      => $this->input->post('status')
            ];

            $this->cabang->insert($data);

            $this->session->set_flashdata('success', 'Cabang berhasil ditambahkan');

            redirect('cabang');
        }
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Cabang',
            'main_view' => 'owner/cabang/edit',
            'cabang' => $this->cabang->get_by_id($id)
        ];

        if (!$data['cabang']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules(
            'nama_cabang',
            'Nama Cabang',
            'required'
        );

        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $this->edit($id);
        } else {

            $cabang = $this->cabang->get_by_id($id);

            $logo = $cabang->logo;

            // upload logo baru
            if (!empty($_FILES['logo']['name'])) {

                $config['upload_path']   = './uploads/logo/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo')) {

                    if ($logo && file_exists('./uploads/logo/' . $logo)) {
                        unlink('./uploads/logo/' . $logo);
                    }

                    $upload = $this->upload->data();
                    $logo = $upload['file_name'];
                }
            }

            $data = [
                'nama_cabang' => htmlspecialchars($this->input->post('nama_cabang', true)),
                'alamat'      => htmlspecialchars($this->input->post('alamat', true)),
                'no_wa'       => htmlspecialchars($this->input->post('no_wa', true)),
                'status'      => htmlspecialchars($this->input->post('status', true)),
                'logo'        => $logo
            ];

            $this->cabang->update($id, $data);

            $this->session->set_flashdata('success', 'Cabang berhasil diupdate');

            redirect('cabang');
        }
    }

    public function delete($id)
    {
        $cabang = $this->cabang->get_by_id($id);

        if (!$cabang) {
            show_404();
        }

        if ($cabang->logo && file_exists('./uploads/logo/' . $cabang->logo)) {
            unlink('./uploads/logo/' . $cabang->logo);
        }

        $this->cabang->delete($id);

        $this->session->set_flashdata('success', 'Cabang berhasil dihapus');

        redirect('cabang');
    }
}
