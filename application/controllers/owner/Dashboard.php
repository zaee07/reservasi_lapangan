<?php
require_once APPPATH . 'core/Owner_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Owner_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Cabang_model', 'cabang');
		$this->load->model('Pengguna_model', 'pengguna');
		$this->load->model('Booking_model', 'booking');
		$this->load->model('Laporan_model', 'laporan');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['active'] = 'dashboard';
		$data['main_view'] = 'owner/dashboard';
		$data['total_cabang'] = $this->cabang->get_total_cabang();
		$data['total_booking'] = $this->booking->get_total_booking();
		$data['total_member'] = $this->pengguna->get_total_member();
		$data['total_pendapatan'] = $this->booking->get_total_pendapatan();
		$data['booking_hari_ini'] = $this->booking->get_booking_hari_ini();
		$data['checkin_hari_ini'] = $this->booking->get_checkin_hari_ini();
		$data['pending_booking'] = $this->booking->get_pending_booking();
		$data['expired_booking'] = $this->booking->get_total_expired_booking();
		$data['booking_7_hari'] = $this->booking->get_booking_7_hari();
		$data['pendapatan_7_hari'] = $this->booking->get_pendapatan_7_hari();
		$data['top_cabang'] = $this->laporan->pendapatan_per_cabang(date('Y-m-01'), date('Y-m-d'));
		$data['ranking_cabang'] = $this->cabang->get_ranking_cabang();
		$data['lapangan_terlaris'] = $this->booking->get_lapangan_terlaris();
		$this->load->view('templates/header', $data);
	}
}
