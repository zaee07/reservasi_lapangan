<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function get_laporan($cabang_id, $tanggal_awal, $tanggal_akhir, $status = null, $tipe = null)
    {
        $this->db
            ->select('
                booking.*,
                lapangan.nama_lapangan,
                pembayaran.invoice_no,
                pembayaran.status_pembayaran
                ')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('pembayaran', 'pembayaran.booking_id = booking.id', 'left')
            ->where('booking.cabang_id', $cabang_id)
            ->where('booking.tanggal_main >=', $tanggal_awal)
            ->where('booking.tanggal_main <=', $tanggal_akhir);

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

    public function total_booking_online($cabang_id, $tanggal_awal, $tanggal_akhir)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->where('tipe_booking', BOOKING_TYPE_ONLINE)
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->count_all_results('booking');
    }

    public function total_booking_walkin($cabang_id, $tanggal_awal, $tanggal_akhir)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->where('tipe_booking', BOOKING_TYPE_OFFLINE)
            ->where('tanggal_main >=', $tanggal_awal)
            ->where('tanggal_main <=', $tanggal_akhir)
            ->count_all_results('booking');
    }

    public function total_booking($cabang_id, $tanggal_awal, $tanggal_akhir)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
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

    public function total_pendapatan($cabang_id, $tanggal_awal, $tanggal_akhir)
    {
        return $this->db
            ->select_sum('total_bayar')
            ->where('cabang_id', $cabang_id)
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
}
