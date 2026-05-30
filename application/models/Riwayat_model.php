<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_model extends CI_Model
{
    public function get_by_user($user_id)
    {
        return $this->db
            ->select('
                booking.*,

                lapangan.nama_lapangan,
                cabang.nama_cabang,

                pembayaran.id as pembayaran_id,
                pembayaran.invoice_no,
                pembayaran.metode_bayar,
                pembayaran.status_pembayaran
            ')
            ->from('booking')

            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id'
            )

            ->join(
                'cabang',
                'cabang.id = booking.cabang_id'
            )

            ->join(
                'pembayaran',
                'pembayaran.booking_id = booking.id',
                'left'
            )

            ->where(
                'booking.user_id',
                $user_id
            )

            ->order_by(
                'booking.id',
                'DESC'
            )

            ->get()
            ->result();
    }

    public function get_detail_booking(
        $booking_id,
        $user_id
    ) {
        return $this->db
            ->select('
                booking.*,

                lapangan.nama_lapangan,
                cabang.nama_cabang,

                pembayaran.id as pembayaran_id,
                pembayaran.invoice_no,
                pembayaran.metode_bayar,
                pembayaran.status_pembayaran,
                pembayaran.paid_at
            ')
            ->from('booking')

            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id'
            )

            ->join(
                'cabang',
                'cabang.id = booking.cabang_id'
            )

            ->join(
                'pembayaran',
                'pembayaran.booking_id = booking.id',
                'left'
            )

            ->where(
                'booking.id',
                $booking_id
            )

            ->where(
                'booking.user_id',
                $user_id
            )

            ->get()
            ->row();
    }

    public function get_booking_slots($booking_id)
    {
        return $this->db
            ->select('
                booking_slot.*,

                jadwal_slot.jam_mulai,
                jadwal_slot.jam_selesai
            ')
            ->from('booking_slot')

            ->join(
                'jadwal_slot',
                'jadwal_slot.id = booking_slot.jadwal_slot_id'
            )

            ->where(
                'booking_slot.booking_id',
                $booking_id
            )

            ->order_by(
                'jadwal_slot.jam_mulai',
                'ASC'
            )

            ->get()
            ->result();
    }

    public function update_booking(
        $booking_id,
        $data
    ) {
        return $this->db
            ->where('id', $booking_id)
            ->update('booking', $data);
    }

    public function release_slot($booking_id)
    {
        $slots = $this->db
            ->get_where(
                'booking_slot',
                [
                    'booking_id' => $booking_id
                ]
            )
            ->result();

        foreach ($slots as $slot) {

            $this->db
                ->where(
                    'id',
                    $slot->jadwal_slot_id
                )
                ->update(
                    'jadwal_slot',
                    [
                        'status_slot'
                        =>
                        STATUS_SLOT_AVAILABLE
                    ]
                );
        }
    }

    public function insert_status_history($data)
    {
        return $this->db
            ->insert(
                'riwayat_status_booking',
                $data
            );
    }
}
