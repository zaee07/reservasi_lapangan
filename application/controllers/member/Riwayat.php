<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Riwayat_model', 'riwayat');
        $this->load->library('payment_service');
    }

    public function index()
    {
        $data = [
            'title'      => 'Riwayat Booking',
            'active'     => 'riwayat_booking',
            'main_view'  => 'user/riwayat/index',
            'riwayat'    => $this->riwayat->get_by_user($this->user['id'])
        ];
        $this->load->view('templates/user_header', $data);
    }

    private function get_booking($booking_id)
    {
        $booking = $this->riwayat->get_detail_booking($booking_id, $this->user['id']);
        if (!$booking) {
            show_404();
        }
        return $booking;
    }

    public function detail($booking_id = null)
    {
        $booking = $this->get_booking($booking_id);
        $data = [
            'title'      => 'Detail Booking',
            'active'     => 'riwayat_booking',
            'main_view'  => 'user/riwayat/detail',
            'booking'    => $booking,
            'slots'      => $this->riwayat->get_booking_slots($booking_id),
            'pembayaran' => $this->riwayat->get_pembayaran($booking_id),
            'riwayat_booking' => $this->riwayat->get_riwayat_booking($booking_id),
            'riwayat_pembayaran' => $this->riwayat->get_riwayat_pembayaran($booking_id)
        ];
        $this->load->view('templates/user_header', $data);
    }

    public function download_qr($booking_id)
    {
        $booking = $this->get_booking($booking_id);
        if (empty($booking->qr_booking)) {
            show_404();
        }
        $file = FCPATH . 'uploads/qrcode/' . $booking->qr_booking;
        if (!file_exists($file)) {
            show_404();
        }
        $this->load->helper('download');
        force_download($file, NULL);
    }

    public function download_pdf($booking_id)
    {
        $booking = $this->get_booking($booking_id);
        $html = $this->load->view('user/booking/pdf', ['booking' => $booking], TRUE);
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream('booking-' . $booking->kode_booking . '.pdf', ['Attachment' => true]);
    }

    public function cancel($booking_id = null)
    {
        $booking = $this->get_booking($booking_id);
        if ($booking->status_booking !== STATUS_BOOKING_PENDING) {
            $this->session->set_flashdata('error', 'Booking tidak dapat dibatalkan');
            return redirect('riwayat_booking');
        }
        $result = $this->payment_service->cancel_payment($booking_id, $this->user['id']);
        if (!$result) {
            $this->session->set_flashdata('error', 'Gagal membatalkan booking');
        } else {
            $this->session->set_flashdata('success', 'Booking berhasil dibatalkan');
        }

        return redirect('riwayat_booking');
    }
}
