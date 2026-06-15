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

    public function booking_hari_ini($cabang_id)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->where('tanggal_main', date('Y-m-d'))
            ->count_all_results('booking');
    }

    public function checkin_hari_ini($cabang_id)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->where('status_booking', STATUS_BOOKING_CHECKIN)
            ->where('tanggal_main', date('Y-m-d'))
            ->count_all_results('booking');
    }

    public function pendapatan_hari_ini($cabang_id)
    {
        return $this->db
            ->select_sum('total_bayar')
            ->where('cabang_id', $cabang_id)
            ->where('status_booking', STATUS_BOOKING_COMPLETED)
            ->where('tanggal_main', date('Y-m-d'))
            ->get('booking')
            ->row()
            ->total_bayar ?? 0;
    }

    public function pendapatan_bulan_ini($cabang_id)
    {
        $awal  = date('Y-m-01');
        $akhir = date('Y-m-t');
        return $this->db
            ->select_sum('total_bayar')
            ->where('cabang_id', $cabang_id)
            ->where('status_booking', STATUS_BOOKING_COMPLETED)
            ->where("tanggal_main BETWEEN '$awal' AND '$akhir'")
            ->get('booking')
            ->row()
            ->total_bayar ?? 0;
    }

    public function pendapatan_tahun_ini($cabang_id)
    {
        $awal  = date('Y-01-01');
        $akhir = date('Y-12-t');
        return $this->db
            ->select_sum('total_bayar')
            ->where('cabang_id', $cabang_id)
            ->where('status_booking', STATUS_BOOKING_COMPLETED)
            ->where("tanggal_main BETWEEN '$awal' AND '$akhir'")
            // ->where('YEAR(tanggal_main)', date('Y'))
            ->get('booking')
            ->row()
            ->total_bayar ?? 0;
    }

    public function pembayaran_unpaid($cabang_id)
    {
        return $this->db
            ->from('pembayaran')
            ->join(
                'booking',
                'booking.id = pembayaran.booking_id'
            )
            ->where('booking.cabang_id', $cabang_id)
            ->where(
                'pembayaran.status_pembayaran',
                STATUS_PEMBAYARAN_UNPAID
            )
            ->count_all_results();
    }

    public function booking_pending($cabang_id)
    {
        return $this->db
            ->select('
                booking.id,
                booking.kode_booking,
                booking.nama_pemesan,
                booking.jam_mulai,
                booking.jam_selesai,
                booking.status_booking,
                booking.total_bayar,
                lapangan.nama_lapangan
            ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.cabang_id', $cabang_id)
            ->where('status_booking', STATUS_BOOKING_PENDING)
            ->get()
            ->result();
    }

    public function booking_hari_ini_list($cabang_id)
    {
        return $this->db
            ->select('
            booking.kode_booking,
            booking.nama_pemesan,
            booking.jam_mulai,
            booking.jam_selesai,
            booking.status_booking,
            lapangan.nama_lapangan
        ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.cabang_id', $cabang_id)
            ->where('booking.tanggal_main', date('Y-m-d'))
            ->order_by('booking.jam_mulai', 'ASC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function booking_7_hari($cabang_id)
    {
        return $this->db
            ->select("
            DATE(tanggal_main) as tanggal,
            COUNT(*) as total
        ")
            ->from('booking')
            ->where('cabang_id', $cabang_id)
            ->where(
                'tanggal_main >=',
                date('Y-m-d', strtotime('-6 days'))
            )
            ->group_by('tanggal_main')
            ->order_by('tanggal_main', 'ASC')
            ->get()
            ->result();
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

    public function update_booking($booking_id, $data)
    {
        return $this->db
            ->where('id', $booking_id)
            ->update('booking', $data);
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
                cabang.nama_cabang,
                pembayaran.id as pembayaran_id,
                pembayaran.invoice_no,
                pembayaran.metode_bayar,
                pembayaran.status_pembayaran
            ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->join('pembayaran', 'pembayaran.booking_id = booking.id')
            ->where('booking.id', $id)
            ->get()
            ->row();
    }

    public function get_booking_by_id_and_code($id, $kode_booking)
    {
        return $this->db
            ->select('booking.*,pembayaran.status_pembayaran, nama_lapangan')
            ->from('booking')
            ->join(
                'pembayaran',
                'pembayaran.booking_id = booking.id',
                'left'
            )
            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id',
                'left'
            )
            ->where('booking.id', $id)
            ->where('booking.kode_booking', $kode_booking)
            ->get()
            ->row();
    }


    public function get_last_booking_by_user_id($uid)
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
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->join('pembayaran', 'pembayaran.booking_id = booking.id', 'left')
            ->where('booking.user_id', $uid)
            ->order_by('booking.id', 'DESC')
            ->get()
            ->row();
    }

    public function has_pending_booking($user_id)
    {
        return $this->db
            ->from('booking')
            ->where('user_id', $user_id)
            ->where('status_booking', STATUS_BOOKING_PENDING)
            ->where('expired_at >', date('Y-m-d H:i:s'))
            ->count_all_results() > 0;
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

    public function checkin($booking_id)
    {
        $this->db
            ->where('id', $booking_id)
            ->update(
                'booking',
                [
                    'status_booking' => STATUS_BOOKING_CHECKIN,
                    'checked_in_at' => date('Y-m-d H:i:s')
                ]
            );

        $this->db
            ->insert(
                'riwayat_status_booking',
                [
                    'booking_id' => $booking_id,
                    'status_booking' => STATUS_BOOKING_CHECKIN,
                    'keterangan' => 'Check-in QR oleh petugas',
                    'diubah_oleh_user_id' => $this->session->userdata('id')
                ]
            );
    }

    public function get_booking_to_complete()
    {
        $now = date('Y-m-d H:i:s');
        return $this->db
            ->where('status_booking', STATUS_BOOKING_CHECKIN)
            ->where("TIMESTAMP(tanggal_main, jam_selesai) < '{$now}'", null, false)
            ->get('booking')
            ->result();
    }

    public function complete_booking($booking_id)
    {
        return $this->db
            ->where('id', $booking_id)
            ->update(
                'booking',
                ['status_booking' => STATUS_BOOKING_COMPLETED, 'completed_at' => date('Y-m-d H:i:s')]
            );
    }
}
