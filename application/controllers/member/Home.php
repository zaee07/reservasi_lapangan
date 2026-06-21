<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Booking_model', 'booking');
		$this->load->model('Lapangan_model', 'lapangan');
		$this->load->model('Pengguna_model', 'pengguna');
	}

	public function index()
	{
		$user_id = $this->user['id'];
		$data = [
			'title'            => 'Home Page',
			'active'           => 'home',
			'main_view'        => 'user/home',
			'user'             => $this->user,
			'booking_aktif'    => $this->booking->count_booking_aktif($user_id),
			'booking_pending'  => $this->booking->count_booking_pending($user_id),
			'booking_terdekat' => $this->booking->get_booking_terdekat($user_id),
			'lapangan'         => $this->lapangan->get_active()
		];

		$this->load->view('templates/user_header', $data);
	}
}
