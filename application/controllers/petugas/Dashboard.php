<?php
require_once APPPATH . 'core/Petugas_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Petugas_Controller
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
		$this->load->model('Booking_model', 'booking');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['active'] = 'dashboard';
		$data['main_view'] = 'petugas/dashboard';
		$data['booking_list_hari_ini'] = $this->booking->booking_hari_ini_list($this->user['cabang_id']);
		$data['checkin_hari_ini'] = $this->booking->checkin_hari_ini($this->user['cabang_id']);
		$data['booking_checkin_pending'] = $this->booking->booking_pending_checkin($this->user['cabang_id']);
		$data['booking_berlangsung'] = $this->booking->booking_berlangsung($this->user['cabang_id']);
		$data['booking_berikutnya'] = $this->booking->booking_berikutnya($this->user['cabang_id']);
		$data['booking_7_hari'] = $this->booking->booking_7_hari($this->user['cabang_id']);
		$data['pendapatan_hari_ini'] = $this->booking->pendapatan_hari_ini($this->user['cabang_id']);
		$this->load->view('templates/header', $data);
	}
}
