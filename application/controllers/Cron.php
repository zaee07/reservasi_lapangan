<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(
            'Booking_model',
            'booking'
        );
    }

    public function expired_booking()
    {
        $bookings = $this->booking
            ->get_expired_booking();

        if (empty($bookings)) {

            echo 'Tidak ada booking expired';

            return;
        }

        $this->db->trans_start();

        foreach ($bookings as $booking) {

            // update booking
            $this->booking->update_booking_status(
                $booking->id,
                STATUS_BOOKING_EXPIRED
            );

            // release slot
            $this->booking->release_slot(
                $booking->id
            );
            $this->booking->insert_status_history([

                'booking_id'          => $booking->id,

                'status_booking'      => STATUS_BOOKING_EXPIRED,

                'keterangan'          => 'Booking expired otomatis',

                'diubah_oleh_user_id' => null

            ]);
        }

        $this->db->trans_complete();

        echo count($bookings)
            . ' booking expired diproses';
    }
}
