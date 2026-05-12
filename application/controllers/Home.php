<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Member_Controller
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
		is_logged_in();
	}
	public function index()
	{
		$data['title'] = 'Home';
		$data['main_view'] = 'user/home';
		$data['active'] = 'home';
		$data['user'] = [
			'nama' => 'Iza'
		];

		$data['booking_aktif'] = 2;
		$data['booking_pending'] = 1;

		$data['lapangan'] = [
			[
				'id' => 1,
				'nama_lapangan' => 'Lapangan 1',
				'jenis_lantai' => 'Vinyl',
				'harga' => 50000,
				'foto' => '',
				'status' => 'Tersedia'
			],
			[
				'id' => 2,
				'nama_lapangan' => 'Lapangan 2',
				'jenis_lantai' => 'Karpet',
				'harga' => 60000,
				'foto' => '',
				'status' => 'Tersedia'
			]
		];
		$this->load->view('templates/user_header', $data);
	}
	/**
	 * total produk ✅
	 * penjualan hari ini ✅
	 * penjualan bulan ini ✅
	 * transaksi hari ini ✅
	 * peringatan stok ✅
	 * download data xls
	 * tambah fitur auth
	 * grafik transaksi 
	 */
}
