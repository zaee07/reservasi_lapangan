<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Pengguna_model', 'pengguna');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect_by_role($this->session->userdata('nama_role'));
		}
		$data['title'] = 'POS | Login';
		$data['main_view'] = 'auth/login';
		// $data['password_hash'] = password_hash('indonesia', PASSWORD_DEFAULT);
		// echo $data['password_hash'];
		$this->load->view('auth/template', $data);
	}

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->pengguna->get_by_email($email);
		// var_dump($user);
		// die();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				if ($user['is_active']) {
					$data = [
						'id' => $user['id'],
						'nama' => $user['nama'],
						'email' => $user['email'],
						'foto' => $user['foto'],
						'role_id' => $user['role_id'],
						'nama_role' => $user['nama_role'],
						'cabang_id' => $user['cabang_id'],
						'nama_cabang' => $user['nama_cabang'],
						'kode_cabang' => $user['kode_cabang'],
						'logged_in' => TRUE
					];
					$this->session->set_userdata($data);
					// var_dump($user['nama_role']);
					// die();
					redirect_by_role($user['nama_role']);
				} else {
					$this->session->set_flashdata('error', 'Akun belum aktif.');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('error', 'Password salah.');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('error', 'Username tidak ditemukan.');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}

	// public function register()
	// {
	// 	$data['title'] = 'POS | Register';
	// 	$data['main_view'] = 'auth/register';
	// 	$this->load->view('auth/template', $data);
	// }

	// public function register_action()
	// {
	// 	$username = $this->input->post('username');
	// 	$email = $this->input->post('email');
	// 	$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

	// 	$data = [
	// 		'username' => $username,
	// 		'email' => $email,
	// 		'password' => $password,
	// 		'role_id' => 2,
	// 		'is_active' => 1
	// 	];

	// 	$this->pengguna->insert_user($data);
	// 	$this->session->set_flashdata('success', 'Registrasi berhasil, silakan login.');
	// 	redirect('auth');
	// }
	public function ubah_password()
	{
		$this->load->helper('auth');
		is_logged_in();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
		$this->form_validation->set_rules(
			'konfirmasi_password',
			'Konfirmasi Password',
			'required|matches[password_baru]'
		);

		if ($this->form_validation->run() === FALSE) {
			$data['title'] = 'Ubah Password';
			$data['main_view'] = 'auth/ubah_password';
			$this->load->view('templates/header', $data);
			return;
		}

		$id = $this->session->userdata('id');
		$password_lama = $this->input->post('password_lama');
		$password_baru = $this->input->post('password_baru');

		$user = $this->pengguna->get_by_id($id);

		if (!password_verify($password_lama, $user['password'])) {
			$this->session->set_flashdata('error', 'Password lama salah.');
			redirect('auth/ubah_password');
			return;
		}

		$data = [
			'password' => password_hash($password_baru, PASSWORD_DEFAULT)
		];

		$this->pengguna->update_user($id, $data);

		$this->session->set_flashdata('success', 'Password berhasil diubah.');
		redirect('dashboard');
	}

	/**
	 * admin = administrator - indonesia
	 * kasir = kasir1 - indonesia
	 * kasir2 = kasir2 - indonesia
	 * owner = owner - indonesia
	 * gudang = gudang1 - indonesia
	 * gudang2 = gudang2 - indonesia
	 */
}
