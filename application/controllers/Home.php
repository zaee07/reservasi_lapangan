<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function index()
	{
		$this->load->model('Cabang_model', 'cabang');
		$this->load->model('Lapangan_model', 'lapangan');
		$this->load->model('Jadwal_model', 'jadwal');

		$tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
		$kode_cabang = $this->input->get('cabang');

		$data = [
			'title' => 'GOR Harmoni',
			'tanggal'     => $tanggal,
			'kode_cabang' => $kode_cabang,
			'cabangs' => $this->jadwal->get_cabang(),
			// 'jadwal'      => $this->jadwal->get_jadwal_slot_by_tgl($tanggal, $kode_cabang),
			'jadwal' => $this->jadwal->get_jadwal_slot_tgl($tanggal, $kode_cabang),
			'lapangan' => $this->db
				->where('status', 'aktif')
				->get('lapangan')
				->result(),

			'total_cabang' => $this->db
				->where('status', 'aktif')
				->count_all_results('cabang'),

			'total_lapangan' => $this->db
				->where('status', 'aktif')
				->count_all_results('lapangan'),

			'total_member' => $this->db
				->where('role_id', 4)
				->count_all_results('user'),

			'total_booking' => $this->db
				->where_not_in('status_booking', [
					STATUS_BOOKING_CANCELLED,
					STATUS_BOOKING_EXPIRED
				])
				->count_all_results('booking')
		];
		$this->load->view('landing/index', $data);
	}

	public function jadwal()
	{
		$this->load->model('Cabang_model', 'cabang');
		$this->load->model('Lapangan_model', 'lapangan');
		$this->load->model('Jadwal_model', 'jadwal');

		$tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
		$kode_cabang = $this->input->get('cabang');

		$data = [
			'title' => 'GOR Harmoni',
			'tanggal'     => $tanggal,
			'kode_cabang' => $kode_cabang,
			'cabangs' => $this->jadwal->get_cabang(),
			// 'jadwal'      => $this->jadwal->get_jadwal_slot_by_tgl($tanggal, $kode_cabang),
			'jadwal' => $this->jadwal->get_jadwal_slot_tgl($tanggal, $kode_cabang)
		];
		$this->load->view('landing/jadwal', $data);
	}
}
