<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas_cabang extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Petugas_cabang_model', 'petugas');
        $this->load->model('Pengguna_model', 'pengguna');
        // $this->load->library('form_validation');
    }

    public function index()
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;
        $data = [
            'title' => 'Data petugas Cabang',
            'main_view' => 'admin/petugas_cabang/index',
            'petugas' => $this->petugas->get_all($cabang_id)
        ];

        $this->load->view('templates/header', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Tambah petugas Cabang',
            'main_view' => 'admin/petugas_cabang/create',
            'cabang_id'  => $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id
        ];

        $this->load->view('templates/header', $data);
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('no_hp', 'Nomor Telepon', 'required|is_unique[user.no_hp]');
        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('password_konfirmasi', 'Konfirmasi Password', 'required|matches[password]');

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
                $config['detect_mime'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('foto')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin_cabang/create');
                }
                $upload = $this->upload->data();
                $foto = $upload['file_name'];
            }

            $data = [
                'role_id'   => 3, // petugas_cabang
                'cabang_id' => $this->input->post('cabang_id'),
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'email'     => htmlspecialchars($this->input->post('email', true)),
                'no_hp'     => htmlspecialchars($this->input->post('no_hp', true)),
                'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'foto'      => $foto,
                'is_active' => $this->input->post('is_active')
            ];
            $this->petugas->insert($data);
            $this->session->set_flashdata('success', 'petugas cabang berhasil ditambahkan');
            redirect('petugas_cabang');
        }
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit petugas Cabang',
            'main_view' => 'admin/petugas_cabang/edit',
            'petugas'  => $this->petugas->get_by_id($id),
            'cabang_id' => $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id
        ];
        if (!$data['petugas']) {
            show_404();
        }
        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $petugas = $this->petugas->get_by_id($id);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $foto = $petugas->foto;
            // upload foto baru
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/user/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;
                $config['detect_mime'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('foto')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin_cabang/create');
                }
                if ($foto && file_exists('./uploads/user/' . $foto)) {
                    unlink('./uploads/user/' . $foto);
                }
                $upload = $this->upload->data();
                $foto = $upload['file_name'];
            }

            $data = [
                'cabang_id' => $this->input->post('cabang_id'),
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'no_hp'     => htmlspecialchars($this->input->post('no_hp', true)),
                'foto'      => $foto,
                'is_active' => $this->input->post('is_active')
            ];
            $this->petugas->update($id, $data);
            $this->session->set_flashdata('success', 'petugas cabang berhasil diupdate');
            redirect('petugas_cabang');
        }
    }

    public function password($id)
    {
        $user = $this->pengguna->get_by_id($id);
        if (!$user || $user['role_id'] != 3) {
            show_404();
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('password_konfirmasi', 'Konfirmasi Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Ubah Password Petugas';
            $data['main_view'] = 'admin/petugas_cabang/ubah_password';
            $data['petugas'] = $user;
            $this->load->view('templates/header', $data);
            return;
        }
        $password_baru = $this->input->post('password_baru');
        $data = [
            'password' => password_hash($password_baru, PASSWORD_DEFAULT)
        ];
        $this->pengguna->update_user($id, $data);
        $this->session->set_flashdata('success', 'Password Petugas berhasil diubah.');
        redirect('petugas_cabang');
    }

    public function delete($id)
    {
        $petugas = $this->petugas->get_by_id($id);
        if (!$petugas) {
            show_404();
        }
        if ($petugas->foto && file_exists('./uploads/user/' . $petugas->foto)) {
            unlink('./uploads/user/' . $petugas->foto);
        }
        $this->petugas->delete($id);
        $this->session->set_flashdata('success', 'petugas cabang berhasil dihapus');

        redirect('petugas_cabang');
    }
}
