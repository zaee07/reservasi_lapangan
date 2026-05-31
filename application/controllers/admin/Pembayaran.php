<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Pembayaran_model', 'pembayaran');
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal');
        $status = $this->input->get('status');

        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;

        $data = [
            'title'      => 'Pembayaran',
            'active'     => 'pembayaran',
            'main_view'  => 'admin/pembayaran/index',
            'tanggal'    => $tanggal,
            'status'     => $status,
            'pembayaran' => $this->pembayaran->get_pembayaran($cabang_id, $tanggal, $status)
        ];
        $this->load->view(
            'templates/header',
            $data
        );
    }

    public function detail($id)
    {
        $cabang_id = $this->pengguna->get_admin_cabang_by_id($this->user['id'])->cabang_id;
        $pembayaran = $this->pembayaran->get_detail($id, $cabang_id);

        if (!$pembayaran) {
            show_404();
        }

        $data = [
            'title'      => 'Detail Pembayaran',
            'active'     => 'admin/transaksi',
            'main_view'  =>
            'admin/pembayaran/detail',
            'pembayaran' => $pembayaran,
            'riwayat'    =>
            $this->pembayaran->get_riwayat_status($id)
        ];
        $this->load->view('templates/header', $data);
    }
}
