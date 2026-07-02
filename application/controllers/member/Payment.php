<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
        $this->load->library('payment_service');
    }

    public function index($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);
        if (!$booking) {
            show_404();
        }
        if ($booking->user_id != $this->user['id']) {
            show_error('Akses ditolak', 403);
        }

        $payment = $this->pembayaran->get_by_booking($booking_id);
        if (!$payment) {
            show_error('Data pembayaran tidak ditemukan');
        }
        if ($booking->status_booking != STATUS_BOOKING_PENDING) {
            redirect('riwayat_booking/detail/' . $booking_id);
            return;
        }

        if (empty($payment->raw_response)) {
            $result = $this->payment_service->create_qris($booking, $payment);
            if (!$result['success']) {
                show_error($result['message']);
            }
            redirect('payment/' . $booking_id);
            return;
        }

        $payment = $this->pembayaran->get_by_booking($booking_id);

        $data = [
            'title'       => 'Pembayaran',
            'active'      => 'booking',
            'main_view'   => 'user/payment/index',
            'booking'     => $booking,
            'pembayaran'  => $payment
        ];

        $this->load->view('templates/user_header', $data);
    }

    private function json_response($status, $data = [])
    {
        header('Content-Type: application/json');
        echo json_encode(array_merge(['status' => $status], $data));

        exit;
    }

    public function ajax_status($invoice)
    {
        $payment = $this->pembayaran->get_by_invoice($invoice);
        if (!$payment) {
            return $this->json_response('not_found');
        }

        if ($payment->status_pembayaran == STATUS_PEMBAYARAN_PAID) {
            return $this->json_response('paid');
        }

        $gateway = $this->payment_service->check_gateway($payment);
        $status = '';

        if ($gateway['success'] && isset($gateway['response']['transaction'])) {
            $status = strtolower($gateway['response']['transaction']['status']);
        }
        switch ($status) {
            case 'completed':
                $this->payment_service->confirm_payment($payment, $gateway['response']);
                return $this->json_response('paid');
            case 'canceled':
                $this->payment_service->expire_payment($payment);
                return $this->json_response('expired');
        }
        log_message('error', 'Masuk ajax expire');
        if (strtotime($payment->expired_at) <= time()) {
            log_message('error', 'Masuk expire');
            $this->payment_service->expire_payment($payment);
            return $this->json_response('expired');
        }
        return $this->json_response('unpaid');
    }

    public function success($invoice)
    {
        $payment = $this->pembayaran->get_by_invoice($invoice);
        if (!$payment) {
            show_404();
        }

        $booking = $this->booking->get_booking_by_id($payment->booking_id);
        if ($booking->user_id != $this->user['id']) {
            show_error('Akses ditolak', 403);
        }
        $data = [
            'title'      => 'Pembayaran Berhasil',
            'active'     => 'riwayat_booking',
            'main_view'  => 'user/payment/succes',
            'booking'    => $booking,
            'pembayaran' => $payment
        ];

        $this->load->view('templates/user_header', $data);
    }
}
