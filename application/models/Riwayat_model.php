<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Riwayat_model extends CI_Model
{
    protected $table = 'booking';
    // list riwayat booking member
    public function get_by_user($user_id)
    {
        return $this->db
            ->select('
                booking.*,
                cabang.nama_cabang,
                lapangan.nama_lapangan,
                pembayaran.status_pembayaran,
                pembayaran.metode_bayar,
                pembayaran.invoice_no
            ')
            ->from('booking')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('pembayaran', 'pembayaran.booking_id = booking.id', 'left')
            ->where('booking.user_id', $user_id)
            ->order_by('booking.id', 'DESC')
            ->get()
            ->result();
    }
    // detail booking
    public function get_detail_booking($booking_id, $user_id)
    {
        return $this->db
            ->select('
                booking.*,
                cabang.nama_cabang,
                lapangan.nama_lapangan,
                lapangan.jenis_lantai
            ')
            ->from('booking')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.id', $booking_id)
            ->where('booking.user_id', $user_id)
            ->get()
            ->row();
    }

    // slot booking
    public function get_booking_slots($booking_id)
    {
        return $this->db
            ->select('
                booking_slot.*,
                jadwal_slot.tanggal,
                jadwal_slot.jam_mulai,
                jadwal_slot.jam_selesai
            ')
            ->from('booking_slot')
            ->join(
                'jadwal_slot',
                'jadwal_slot.id = booking_slot.jadwal_slot_id'
            )
            ->where('booking_slot.booking_id', $booking_id)
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
    }

    // pembayaran
    public function get_pembayaran($booking_id)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->get('pembayaran')
            ->row();
    }

    // riwayat booking
    public function get_riwayat_booking($booking_id)
    {
        return $this->db
            ->select('
                riwayat_status_booking.*,
                user.nama
            ')
            ->from('riwayat_status_booking')
            ->join('user', 'user.id = riwayat_status_booking.diubah_oleh_user_id', 'left')
            ->where('booking_id', $booking_id)
            ->order_by('id', 'ASC')
            ->get()
            ->result();
    }

    // riwayat pembayaran
    public function get_riwayat_pembayaran($booking_id)
    {
        return $this->db
            ->select('riwayat_status_pembayaran.*')
            ->from('riwayat_status_pembayaran')
            ->join('pembayaran', 'pembayaran.id = riwayat_status_pembayaran.pembayaran_id')
            ->where('pembayaran.booking_id', $booking_id)
            ->order_by('riwayat_status_pembayaran.id', 'ASC')
            ->get()
            ->result();
    }

    // update booking
    public function update_booking($booking_id, $data)
    {
        return $this->db
            ->where('id', $booking_id)
            ->update('booking', $data);
    }

    // update pembayaran
    public function update_pembayaran($pembayaran_id, $data)
    {
        return $this->db
            ->where('id', $pembayaran_id)
            ->update('pembayaran', $data);
    }

    // insert riwayat booking
    public function insert_status_history($data)
    {
        return $this->db->insert('riwayat_status_booking', $data);
    }

    // insert riwayat pembayaran
    public function insert_riwayat_pembayaran($data)
    {
        return $this->db->insert('riwayat_status_pembayaran', $data);
    }

    // release slot
    public function release_slot($booking_id)
    {
        $slots = $this->db
            ->where('booking_id', $booking_id)
            ->get('booking_slot')
            ->result();
        foreach ($slots as $slot) {
            $this->db
                ->where('id', $slot->jadwal_slot_id)
                ->update(
                    'jadwal_slot',
                    [
                        'status_slot' => 'available'
                    ]
                );
        }
    }
}
