<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function run()
	{
		$this->load->model('Booking_model', 'booking');
		$bookings = $this->booking->get_expired_booking();

		foreach ($bookings as $booking) {

			// update booking
			$this->db
				->where('id', $booking->id)
				->update('booking', [
					'status_booking' => STATUS_BOOKING_EXPIRED
				]);

			// buka slot lagi
			$this->booking->release_slot($booking->id);
		}
	}
}
