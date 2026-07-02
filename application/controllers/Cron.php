<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
        $this->load->library('payment_service');
    }

    public function expired_booking()
    {
        $bookings = $this->booking->get_expired_booking();
        if (empty($bookings)) {
            echo 'Tidak ada booking expired';
            return;
        }
        foreach ($bookings as $booking) {
            $payment = $this->pembayaran->get_by_booking($booking->id);
            if (!$payment) {
                continue;
            }
            $result = $this->payment_service->expire_payment($payment);
            if (!$result) {
                log_message('error', 'Cron expire gagal. Booking ID : ' . $booking->id);
            }
        }
        echo date('Y-m-d H:i:s') . ' | ' . count($bookings) . ' booking expired';
    }

    public function complete_booking()
    {
        $bookings = $this->booking->get_booking_to_complete();
        if (empty($bookings)) {
            echo 'Tidak ada booking selesai';
            return;
        }
        $this->db->trans_start();
        foreach ($bookings as $booking) {
            $this->booking->complete_booking($booking->id);
            $this->booking->insert_status_history([
                'booking_id' => $booking->id,
                'status_booking' => STATUS_BOOKING_COMPLETED,
                'keterangan' => 'Booking selesai otomatis',
                'diubah_oleh_user_id' => null
            ]);
        }
        $this->db->trans_complete();
        echo count($bookings) . ' booking completed';
    }
}
