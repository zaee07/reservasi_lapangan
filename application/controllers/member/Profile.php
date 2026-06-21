<?php
require_once APPPATH . 'core/Member_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'title'     => 'Profile',
            'active'    => 'profile',
            'main_view' => 'user/profile/index',
            'user'      => $this->pengguna->get_by_id($this->user['id'])
        ];

        $this->load->view('templates/user_header', $data);
    }

    public function valid_no_hp($no_hp)
    {
        if (preg_match('/^08[0-9]{8,11}$/', $no_hp) || preg_match('/^\+62[0-9]{9,12}$/', $no_hp)) {
            return TRUE;
        }

        $this->form_validation->set_message('valid_no_hp', 'Format nomor telepon tidak valid');
        return FALSE;
    }

    public function edit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('no_hp', 'Nomor Telepon', 'required|trim|callback_valid_no_hp');
        $user = $this->pengguna->get_by_id($this->user['id']);
        $email = trim($this->input->post('email'));
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title'     => 'Edit Profile',
                'active'    => 'profile',
                'back'      => 'profile',
                'main_view' => 'user/profile/edit',
                'user'      => $user
            ];

            $this->load->view('templates/user_header', $data);
            return;
        }
        if ($this->pengguna->email_exists($email, $user['id'])) {
            $this->session->set_flashdata('error', 'Email sudah digunakan');
            redirect('profile/edit');
        }
        $foto = $user['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './uploads/user/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $upload = $this->upload->data();
                if (!empty($user['foto']) && file_exists('./uploads/user/' . $user['foto'])) {
                    unlink('./uploads/user/' . $user['foto']);
                }
                $foto = $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                redirect('profile/edit');
            }
        }
        $data = [
            'nama'  => $this->input->post('nama'),
            'email' => $email,
            'no_hp' => $this->input->post('no_hp'),
            'foto'  => $foto
        ];

        $this->pengguna->update_user($user['id'], $data);
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        redirect('profile');
    }

    public function ubah_password()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title'     => 'Ubah Password',
                'active'    => 'profile',
                'back'      => 'profile',
                'main_view' => 'user/profile/ubah_password'
            ];

            $this->load->view('templates/user_header', $data);
            return;
        }

        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi    = $this->input->post('konfirmasi_password');
        $user = $this->pengguna->get_by_id($this->user['id']);

        if (!password_verify($password_lama, $user['password'])) {
            $this->session->set_flashdata('error', 'Password lama salah');
            redirect('profile/ubah_password');
        }
        if ($password_baru != $konfirmasi) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok');
            redirect('profile/ubah_password');
        }

        $this->pengguna->update_user($user['id'], ['password' => password_hash($password_baru, PASSWORD_DEFAULT)]);
        $this->session->set_flashdata('success', 'Password berhasil diubah');

        redirect('profile');
    }

    public function hapus_foto()
    {
        $user = $this->pengguna->get_by_id($this->user['id']);
        if (!empty($user['foto']) && file_exists('./uploads/user/' . $user['foto'])) {
            unlink('./uploads/user/' . $user['foto']);
            $this->pengguna->update_user($user['id'], ['foto' => null]);
        }
        $this->session->set_flashdata('success', 'Foto profil berhasil dihapus');
        redirect('profile/edit');
    }
}
