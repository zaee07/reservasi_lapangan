<?php
require_once APPPATH . 'core/Owner_Controller.php';
// use MY_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Owner_Controller
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
	// function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->helper('auth');
	// 	is_logged_in();
	// 	check_role('admin_cabang');
	// 	// $this->load->model('Produk_model', 'produk');
	// 	// $this->load->model('Transaksi_model', 'transaksi');
	// }
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['main_view'] = 'owner/dashboard';
		$data['total_booking'] = 10;
		$data['pendapatan_hari_ini'] = 500000;
		$data['pendapatan_bulan_ini'] = 1000000;
		$data['pendapatan_tahun_ini'] = 12000000;
		$this->load->view('templates/header', $data);
	}
}
