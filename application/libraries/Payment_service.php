<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model('Booking_model', 'booking');
        $this->CI->load->model('Pembayaran_model', 'pembayaran');

        $this->CI->load->library('pakasir');

        $this->CI->load->helper(['payment', 'qrcode']);
    }
    public function create_qris($booking, $payment)
    {
        $gateway = $this->CI->pakasir->create_transaction($payment->invoice_no, (int)$booking->total_bayar);

        if (!$gateway['success'] || !isset($gateway['response']['payment']['payment_number'])) {
            return [
                'success' => false,
                'message' => 'Gagal membuat QRIS',
                'gateway' => $gateway
            ];
        }

        $qr = generate_qris($gateway['response']['payment']['payment_number'], $payment->invoice_no);

        $this->CI->pembayaran->update(
            $payment->id,
            [
                'qr_image' => $qr,
                'raw_response' => json_encode($gateway['response']),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );

        return ['success' => true, 'gateway' => $gateway];
    }
    public function check_gateway($payment)
    {
        return $this->CI->pakasir->detail_transaction($payment->invoice_no, (int) $payment->nominal);
    }

    public function confirm_payment($payment, $gateway)
    {
        $booking = $this->CI->booking->get_booking_by_id($payment->booking_id);

        if (!$booking) {
            return false;
        }
        if ($booking->status_booking == STATUS_BOOKING_CONFIRMED || $payment->status_pembayaran == STATUS_PEMBAYARAN_PAID) {
            return true;
        }

        $this->CI->db->trans_start();
        // $this->CI->booking->update_booking_status($booking->id, STATUS_BOOKING_CONFIRMED);

        $bookingQr = generate_booking_qr($booking->id, $booking->kode_booking);
        $this->CI->booking->update_booking(
            $booking->id,
            [
                'status_booking' => STATUS_BOOKING_CONFIRMED,
                'qr_booking' => $bookingQr,
                'confirmed_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]
        );
        $this->CI->booking->insert_status_history([
            'booking_id'          => $booking->id,
            'status_booking'      => STATUS_BOOKING_CONFIRMED,
            'keterangan'          => 'Pembayaran berhasil',
            'diubah_oleh_user_id' => null
        ]);

        $this->CI->pembayaran->payment_success($booking->id, $gateway);
        if ($payment->status_pembayaran != STATUS_PEMBAYARAN_PAID) {
            $this->CI->pembayaran->insert_riwayat_pembayaran([
                'pembayaran_id'     => $payment->id,
                'status_pembayaran' => STATUS_PEMBAYARAN_PAID,
                'keterangan'        => 'Pembayaran QRIS berhasil'
            ]);
        }

        $this->CI->db->trans_complete();
        if (!$this->CI->db->trans_status()) {
            return false;
        }
        return true;
    }

    public function expire_payment($payment)
    {
        if ($payment->status_pembayaran == STATUS_PEMBAYARAN_EXPIRED) {
            return true;
        }
        log_message('error', '1');
        if ($payment->status_pembayaran == STATUS_PEMBAYARAN_PAID) {
            return true;
        }
        log_message('error', '2');

        $booking = $this->CI->booking->get_booking_by_id($payment->booking_id);
        if (!$booking) {
            return false;
        }
        log_message('error', '3');
        if (in_array($booking->status_booking, [STATUS_BOOKING_EXPIRED, STATUS_BOOKING_CANCELLED, STATUS_BOOKING_COMPLETED])) {
            return true;
        }
        log_message('error', '4');


        $gateway = $this->CI->pakasir->cancel_transaction($payment->invoice_no, (int)$booking->total_bayar);
        if (!$gateway['success']) {
            log_message('error', json_encode($gateway));
        }
        log_message('error', '5');
        $this->CI->db->trans_start();

        $this->CI->booking->update_booking($booking->id, ['status_booking' => STATUS_BOOKING_EXPIRED, 'updated_at' => date('Y-m-d H:i:s')]);
        log_message('error', '6');
        $this->CI->booking->insert_status_history([
            'booking_id'          => $booking->id,
            'status_booking'      => STATUS_BOOKING_EXPIRED,
            'keterangan'          => 'Booking expired otomatis',
            'diubah_oleh_user_id' => null
        ]);
        log_message('error', '7');
        $response = $gateway['response'] ?? [];
        $this->CI->pembayaran->payment_cancel($booking->id, $response);
        log_message('error', '8');
        $this->CI->pembayaran->insert_riwayat_pembayaran([
            'pembayaran_id'     => $payment->id,
            'status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED,
            'keterangan'        => 'Pembayaran expired'
        ]);
        log_message('error', '9');
        $this->CI->booking->release_slot($booking->id);
        log_message('error', '10');
        $this->CI->db->trans_complete();
        log_message('error', '11');
        if (!$this->CI->db->trans_status()) {
            return false;
        }
        return true;
    }

    public function cancel_payment($booking_id, $user_id = null)
    {
        $booking = $this->CI->booking->get_booking_by_id($booking_id);
        if (!$booking) {
            return false;
        }
        if (in_array($booking->status_booking, [STATUS_BOOKING_CANCELLED, STATUS_BOOKING_EXPIRED, STATUS_BOOKING_COMPLETED])) {
            return true;
        }

        $payment = $this->CI->pembayaran->get_by_booking($booking_id);
        if (!$payment || $payment->status_pembayaran == STATUS_PEMBAYARAN_PAID) {
            return false;
        }

        $gateway = $this->CI->pakasir->cancel_transaction($payment->invoice_no, (int)$booking->total_bayar);
        if (!$gateway['success']) {
            log_message('error', json_encode($gateway));
        }

        $this->CI->db->trans_start();

        $this->CI->booking->update_booking(
            $booking_id,
            [
                'status_booking' => STATUS_BOOKING_CANCELLED,
                'cancelled_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]
        );
        $this->CI->booking->insert_status_history([
            'booking_id'          => $booking_id,
            'status_booking'      => STATUS_BOOKING_CANCELLED,
            'keterangan'          => 'Booking dibatalkan member',
            'diubah_oleh_user_id' => $user_id
        ]);
        $response = $gateway['response'] ?? [];
        $this->CI->pembayaran->payment_cancel($booking_id, $response);
        if ($payment->status_pembayaran != STATUS_PEMBAYARAN_EXPIRED) {
            $this->CI->pembayaran->insert_riwayat_pembayaran([
                'pembayaran_id'     => $payment->id,
                'status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED,
                'keterangan'        => 'Booking dibatalkan member'
            ]);
        }
        $this->CI->booking->release_slot($booking_id);

        $this->CI->db->trans_complete();
        if (!$this->CI->db->trans_status()) {
            return false;
        }
        return true;
    }
}
