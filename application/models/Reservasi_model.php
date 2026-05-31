<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi_model extends CI_Model
{
    public function get_reservasi($cabang_id, $tanggal, $status = null)
    {
        $this->db
            ->select('
                booking.*,
                lapangan.nama_lapangan,
                pembayaran.status_pembayaran,
                pembayaran.invoice_no
            ')
            ->from('booking')
            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id'
            )

            ->join(
                'pembayaran',
                'pembayaran.booking_id = booking.id',
                'left'
            )

            ->where(
                'booking.cabang_id',
                $cabang_id
            )

            ->where(
                'booking.tanggal_main',
                $tanggal
            );

        if ($status) {

            $this->db->where(
                'booking.status_booking',
                $status
            );
        }

        return $this->db
            ->order_by(
                'booking.jam_mulai',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function get_detail_booking(
        $booking_id,
        $cabang_id
    ) {
        return $this->db
            ->select('
                booking.*,

                lapangan.nama_lapangan,
                cabang.nama_cabang,

                pembayaran.invoice_no,
                pembayaran.status_pembayaran,
                pembayaran.metode_bayar,
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
                'booking.cabang_id',
                $cabang_id
            )

            ->get()
            ->row();
    }

    public function get_booking_slots(
        $booking_id
    ) {
        return $this->db
            ->select('
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
}
