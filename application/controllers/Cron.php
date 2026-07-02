<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model', 'booking');
        $this->load->model('Riwayat_model', 'riwayat');
        $this->load->library('pakasir');
    }

    public function expired_booking()
    {
        $bookings = $this->booking->get_expired_booking();
        if (empty($bookings)) {
            echo 'Tidak ada booking expired';
            return;
        }
        foreach ($bookings as $booking) {
            $this->db->trans_start();
            // update booking
            $this->booking->update_booking_status($booking->id, STATUS_BOOKING_EXPIRED);
            // release slot
            $this->booking->release_slot($booking->id);
            $this->booking->insert_status_history([
                'booking_id'          => $booking->id,
                'status_booking'      => STATUS_BOOKING_EXPIRED,
                'keterangan'          => 'Booking expired otomatis',
                'diubah_oleh_user_id' => null
            ]);
            $pembayaran = $this->riwayat->get_pembayaran($booking->id);
            if ($pembayaran) {
                $result = $this->pakasir->cancel_transaction($pembayaran->invoice_no, $booking->total_bayar);
                log_message(
                    'debug',
                    'Cancel Gateway : ' . json_encode($result)
                );
                $this->riwayat->update_pembayaran($pembayaran->id, ['status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED, 'raw_response' => json_encode($result)]);
                $this->riwayat->insert_riwayat_pembayaran([
                    'pembayaran_id'     => $pembayaran->id,
                    'status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED,
                    'keterangan'        => 'Booking dibatalkan karena Pembayaran expired'
                ]);
            }
            $this->db->trans_complete();
        }
        echo date('Y-m-d H:i:s') . ' | ' . count($bookings) . ' booking expired';
        echo "<pre>";
        print_r($result);
        die();
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
        echo count($bookings)
            . ' booking completed';
    }
}
