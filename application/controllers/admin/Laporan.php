<?php
require_once APPPATH . 'core/Admin_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model', 'laporan');
    }

    public function index()
    {
        $tanggal_awal  = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $status        = $this->input->get('status');
        $tipe          = $this->input->get('tipe');

        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }

        $data = [
            'title'          => 'Laporan',
            'active'         => 'laporan',
            'main_view'      => 'admin/laporan/index',
            'tanggal_awal'   => $tanggal_awal,
            'tanggal_akhir'  => $tanggal_akhir,
            'status'         => $status,
            'tipe'           => $tipe,
            'laporan'        => $this->laporan->get_laporan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir,
                $status,
                $tipe
            ),
            'total_booking' => $this->laporan->total_booking(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            )
        ];

        $this->load->view('templates/header', $data);
    }

    public function export_pdf()
    {
        $tanggal_awal  = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $status        = $this->input->get('status');
        $tipe          = $this->input->get('tipe');
        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }

        $data = [
            'laporan' => $this->laporan->get_laporan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir,
                $status,
                $tipe
            ),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'total_booking' => $this->laporan->total_booking(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'booking_online' => $this->laporan->total_booking_online(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'booking_walkin' => $this->laporan->total_booking_walkin(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            )
        ];

        $html = $this->load->view('admin/laporan/pdf', $data, true);
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream('laporan-booking-' . date('YmdHi') . '.pdf', ['Attachment' => true]);
    }

    public function export_excel()
    {
        $tanggal_awal  = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $status        = $this->input->get('status');
        $tipe          = $this->input->get('tipe');
        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }
        $data = [
            'laporan' => $this->laporan->get_laporan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir,
                $status,
                $tipe
            ),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'total_booking' => $this->laporan->total_booking(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'booking_online' => $this->laporan->total_booking_online(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'booking_walkin' => $this->laporan->total_booking_walkin(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $this->user['cabang_id'],
                $tanggal_awal,
                $tanggal_akhir
            )
        ];

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Booking_" . date('YmdHis') . ".xls");
        $this->load->view('admin/laporan/excel', $data);
    }
}
