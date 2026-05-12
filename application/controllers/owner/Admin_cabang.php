<?php
require_once APPPATH . 'core/Owner_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_cabang extends Owner_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_cabang_model', 'admin');
        // $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Admin Cabang',
            'main_view' => 'owner/admin_cabang/index',
            'admin' => $this->admin->get_all()
        ];

        $this->load->view('templates/header', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Tambah Admin Cabang',
            'main_view' => 'owner/admin_cabang/create',
            'cabang'  => $this->admin->get_cabang()
        ];

        $this->load->view('templates/header', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->create();
        } else {

            $foto = null;

            // upload foto
            if (!empty($_FILES['foto']['name'])) {

                $config['upload_path']   = './uploads/user/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {

                    $upload = $this->upload->data();
                    $foto = $upload['file_name'];
                }
            }

            $data = [
                'role_id'   => 2, // admin_cabang
                'cabang_id' => $this->input->post('cabang_id'),
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'email'     => htmlspecialchars($this->input->post('email', true)),
                'no_hp'     => htmlspecialchars($this->input->post('no_hp', true)),
                'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'foto'      => $foto,
                'is_active' => $this->input->post('is_active')
            ];

            $this->admin->insert($data);

            $this->session->set_flashdata('success', 'Admin cabang berhasil ditambahkan');

            redirect('admin_cabang');
        }
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Admin Cabang',
            'main_view' => 'owner/admin_cabang/edit',
            'admin'  => $this->admin->get_by_id($id),
            'cabang' => $this->admin->get_cabang()
        ];

        if (!$data['admin']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $admin = $this->admin->get_by_id($id);

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->edit($id);
        } else {

            $foto = $admin->foto;

            // upload foto baru
            if (!empty($_FILES['foto']['name'])) {

                $config['upload_path']   = './uploads/user/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {

                    if ($foto && file_exists('./uploads/user/' . $foto)) {
                        unlink('./uploads/user/' . $foto);
                    }

                    $upload = $this->upload->data();
                    $foto = $upload['file_name'];
                }
            }

            $data = [
                'cabang_id' => $this->input->post('cabang_id'),
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'no_hp'     => htmlspecialchars($this->input->post('no_hp', true)),
                'foto'      => $foto,
                'is_active' => $this->input->post('is_active')
            ];

            // update password jika diisi
            if ($this->input->post('password')) {
                $data['password'] = password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                );
            }

            $this->admin->update($id, $data);

            $this->session->set_flashdata('success', 'Admin cabang berhasil diupdate');

            redirect('admin_cabang');
        }
    }

    public function delete($id)
    {
        $admin = $this->admin->get_by_id($id);

        if (!$admin) {
            show_404();
        }

        if ($admin->foto && file_exists('./uploads/user/' . $admin->foto)) {
            unlink('./uploads/user/' . $admin->foto);
        }

        $this->admin->delete($id);

        $this->session->set_flashdata('success', 'Admin cabang berhasil dihapus');

        redirect('admin_cabang');
    }
}
