<?php
require_once APPPATH . 'core/Admin_Controller.php';
// use MY_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
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
		$this->load->model('Lapangan_model', 'lapangan');
		// $this->load->model('Transaksi_model', 'transaksi');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['main_view'] = 'admin/dashboard';
		$data['booking_hari_ini'] = $this->booking->booking_hari_ini($this->user['cabang_id']);
		$data['booking_list_hari_ini'] = $this->booking->booking_hari_ini_list($this->user['cabang_id']);
		$data['pembayaran_unpaid'] = $this->booking->pembayaran_unpaid($this->user['cabang_id']);
		$data['booking_pending'] = $this->booking->booking_pending($this->user['cabang_id']);
		$data['checkin_hari_ini'] = $this->booking->checkin_hari_ini($this->user['cabang_id']);
		$data['booking_7_hari'] = $this->booking->booking_7_hari($this->user['cabang_id']);
		$data['total_booking'] = $this->booking->booking_hari_ini($this->user['cabang_id']);
		$data['pendapatan_hari_ini'] = $this->booking->pendapatan_hari_ini($this->user['cabang_id']);
		$data['pendapatan_bulan_ini'] = $this->booking->pendapatan_bulan_ini($this->user['cabang_id']);
		$data['pendapatan_tahun_ini'] = $this->booking->pendapatan_tahun_ini($this->user['cabang_id']);
		// $data['total_lapangan'] = $this->produk->total_barang();
		$data['terlaris'] = $this->lapangan->get_lapangan_terlaris($this->user['cabang_id']);
		// $data['transaksi'] = $this->transaksi->transaksi_hari_ini();
		// $data['pendapatan_hari_ini'] = $this->transaksi->get_pendapatan_hari_ini();
		// $data['pendapatan_bulan_ini'] = $this->transaksi->get_pendapatan_bulan_ini();
		// $data['pendapatan_tahun_ini'] = $this->transaksi->get_pendapatan_tahun_ini();
		// var_dump($this->session->userdata);
		// die();
		$this->load->view('templates/header', $data);
	}
}
