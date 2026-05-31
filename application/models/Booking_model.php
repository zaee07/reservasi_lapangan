<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{
    public function get_slot_tersedia($tanggal)
    {
        $result = $this->db
            ->select('jadwal_slot.*,lapangan.nama_lapangan,cabang.nama_cabang')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->join('cabang', 'cabang.id = jadwal_slot.cabang_id')
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('jadwal_slot.status_slot', STATUS_SLOT_AVAILABLE)
            ->order_by('cabang.nama_cabang', 'ASC')
            ->order_by('lapangan.nama_lapangan', 'ASC')
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
        $grouped = [];
        foreach ($result as $row) {
            $grouped[$row->nama_cabang][$row->nama_lapangan][] = $row;
        }
        return $grouped;
    }


    public function get_slot_by_id($id)
    {
        return $this->db
            ->get_where('jadwal_slot', ['id' => $id])
            ->row();
    }

    public function insert_booking($data)
    {
        $this->db->insert('booking', $data);
        return $this->db->insert_id();
    }

    public function insert_booking_slot($data)
    {
        return $this->db->insert('booking_slot', $data);
    }

    public function update_slot($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('jadwal_slot', $data);
    }

    public function update_slot_available($id)
    {
        $this->db
            ->where('id', $id)
            ->where('status_slot', STATUS_SLOT_AVAILABLE)
            ->update('jadwal_slot', ['status_slot' => STATUS_SLOT_BOOKED]);
        return $this->db->affected_rows();
    }

    public function get_expired_booking()
    {
        return $this->db
            ->select('booking.*')
            ->from('booking')
            ->join(
                'pembayaran',
                'pembayaran.booking_id = booking.id',
                'left'
            )
            ->where(
                'booking.status_booking',
                STATUS_BOOKING_PENDING
            )
            ->group_start()
            ->where(
                'pembayaran.status_pembayaran IS NULL',
                null,
                false
            )
            ->or_where(
                'pembayaran.status_pembayaran !=',
                STATUS_PEMBAYARAN_PAID
            )
            ->or_where_in(
                'pembayaran.status_pembayaran',
                [
                    STATUS_PEMBAYARAN_UNPAID,
                    STATUS_PEMBAYARAN_FAILED
                ]
            )
            ->group_end()
            ->where(
                'booking.expired_at <',
                date('Y-m-d H:i:s')
            )
            ->get()
            ->result();
    }

    public function insert_status_history($data)
    {
        return $this->db
            ->insert('riwayat_status_booking', $data);
    }

    public function get_booking_by_id($id)
    {
        return $this->db
            ->select('
                booking.*,
                lapangan.nama_lapangan,
                cabang.nama_cabang
            ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->where('booking.id', $id)
            ->get()
            ->row();
    }

    public function release_slot($booking_id)
    {
        $slots = $this->db
            ->get_where('booking_slot', ['booking_id' => $booking_id])
            ->result();
        foreach ($slots as $slot) {
            $this->db
                ->where('id', $slot->jadwal_slot_id)
                ->update('jadwal_slot', ['status_slot' => STATUS_SLOT_AVAILABLE]);
        }
    }
    public function update_booking_status($booking_id, $status)
    {
        return $this->db
            ->where('id', $booking_id)
            ->update('booking', ['status_booking' => $status]);
    }
}
