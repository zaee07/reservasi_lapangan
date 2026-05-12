<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $user;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->user = $this->session->userdata();
	}

	protected function is_logged_in()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
		}
	}

	protected function check_role($role)
	{
		if ($this->session->userdata('nama_role') != $role) {
			redirect('auth');
		}
	}
}
