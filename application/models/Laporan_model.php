<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function get_laporan($tanggal_awal, $tanggal_akhir, $cabang_id = null, $status = null, $tipe = null)
    {
        $this->db
            ->select('
                booking.*,
                cabang.nama_cabang,
                lapangan.nama_lapangan,
                pembayaran.invoice_no,
                pembayaran.status_pembayaran
                ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->join('pembayaran', 'pembayaran.booking_id = booking.id', 'left')
            ->where('booking.tanggal_main >=', $tanggal_awal)
            ->where('booking.tanggal_main <=', $tanggal_akhir)
            ->where_not_in('status_booking', [STATUS_BOOKING_CANCELLED, STATUS_BOOKING_EXPIRED]);
        if ($cabang_id) {
            $this->db->where('booking.cabang_id', $cabang_id);
        }
        if ($status) {
            $this->db->where('booking.status_booking', $status);
        }
        if ($tipe) {
            $this->db->where('booking.tipe_booking', $tipe);
        }

        return $this->db
            ->order_by('booking.tanggal_main', 'DESC')
            ->get()
            ->result();
    }

    public function total_booking_online($tanggal_awal, $tanggal_akhir, $cabang_id = null)
    {
        if ($cabang_id) {
            $this->db->where('cabang_id', $cabang_id);
        }
        return $this->db
            ->where('tipe_booking', BOOKING_TYPE_ONLINE)
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->where_not_in('status_booking', [STATUS_BOOKING_CANCELLED, STATUS_BOOKING_EXPIRED])
            ->count_all_results('booking');
    }

    public function total_booking_walkin($tanggal_awal, $tanggal_akhir, $cabang_id = null)
    {
        if ($cabang_id) {
            $this->db->where('cabang_id', $cabang_id);
        }
        return $this->db
            ->where('tipe_booking', BOOKING_TYPE_OFFLINE)
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->where_not_in('status_booking', [STATUS_BOOKING_CANCELLED, STATUS_BOOKING_EXPIRED])
            ->count_all_results('booking');
    }

    public function total_booking($tanggal_awal, $tanggal_akhir, $cabang_id = null)
    {
        if ($cabang_id) {
            $this->db->where('cabang_id', $cabang_id);
        }
        return $this->db
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->where_not_in(
                'status_booking',
                [
                    STATUS_BOOKING_CANCELLED,
                    STATUS_BOOKING_EXPIRED
                ]
            )
            ->count_all_results('booking');
    }

    public function total_pendapatan($tanggal_awal, $tanggal_akhir, $cabang_id = null)
    {
        $this->db->select_sum('total_bayar');
        if ($cabang_id) {
            $this->db->where('cabang_id', $cabang_id);
        }
        return $this->db
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->where_in(
                'status_booking',
                [
                    STATUS_BOOKING_COMPLETED,
                    STATUS_BOOKING_CHECKIN,
                    STATUS_BOOKING_CONFIRMED
                ]
            )
            ->get('booking')
            ->row()
            ->total_bayar ?? 0;
    }

    public function pendapatan_per_cabang($tanggal_awal, $tanggal_akhir)
    {
        return $this->db
            ->select('cabang.id, cabang.nama_cabang,SUM(booking.total_bayar) total')
            ->from('booking')
            ->join('cabang', 'cabang.id = booking.cabang_id')
            ->where_in(
                'booking.status_booking',
                [
                    STATUS_BOOKING_COMPLETED,
                    STATUS_BOOKING_CHECKIN,
                    STATUS_BOOKING_CONFIRMED
                ]
            )
            ->where('booking.tanggal_main >=', $tanggal_awal)
            ->where('booking.tanggal_main <=', $tanggal_akhir)
            ->group_by('booking.cabang_id')
            ->order_by('total', 'DESC')
            ->get()
            ->result();
    }
}
