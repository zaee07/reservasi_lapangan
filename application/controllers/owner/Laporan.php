<?php
require_once APPPATH . 'core/Owner_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends Owner_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model', 'laporan');
        $this->load->model('Cabang_model', 'cabang');
    }

    public function index()
    {
        $tanggal_awal  = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $status        = $this->input->get('status');
        $tipe          = $this->input->get('tipe');
        $cabang_id     = $this->input->get('cabang_id');

        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }
        if (!$cabang_id) {
            $cabang_id = null;
        }

        $data = [
            'title'          => 'Laporan',
            'active'         => 'laporan',
            'main_view'      => 'owner/laporan/index',
            'tanggal_awal'   => $tanggal_awal,
            'tanggal_akhir'  => $tanggal_akhir,
            'status'         => $status,
            'tipe'           => $tipe,
            'cabangs' => $this->cabang->get_all(),
            'cabang_id' => $cabang_id,
            'laporan'        => $this->laporan->get_laporan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id,
                $status,
                $tipe
            ),
            'total_booking' => $this->laporan->total_booking(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
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
        $cabang_id     = $this->input->get('cabang_id');
        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }
        if (!$cabang_id) {
            $cabang_id = null;
        }

        $data = [
            'laporan' => $this->laporan->get_laporan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id,
                $status,
                $tipe
            ),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'total_booking' => $this->laporan->total_booking(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'booking_online' => $this->laporan->total_booking_online(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'booking_walkin' => $this->laporan->total_booking_walkin(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            )
        ];

        $html = $this->load->view('owner/laporan/pdf', $data, true);
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
        $cabang_id     = $this->input->get('cabang_id');
        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d');
        }
        if (!$cabang_id) {
            $cabang_id = null;
        }
        $data = [
            'laporan' => $this->laporan->get_laporan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id,
                $status,
                $tipe
            ),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'total_booking' => $this->laporan->total_booking(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'booking_online' => $this->laporan->total_booking_online(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'booking_walkin' => $this->laporan->total_booking_walkin(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            ),
            'total_pendapatan' => $this->laporan->total_pendapatan(
                $tanggal_awal,
                $tanggal_akhir,
                $cabang_id
            )
        ];

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Booking_" . date('YmdHis') . ".xls");
        $this->load->view('owner/laporan/excel', $data);
    }
}
