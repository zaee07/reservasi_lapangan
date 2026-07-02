<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    public function get_pembayaran($cabang_id, $tanggal, $status = null)
    {
        $this->db
            ->select('
                pembayaran.*,
                booking.kode_booking,
                booking.nama_pemesan,
                booking.total_bayar,
                booking.tanggal_main,
                lapangan.nama_lapangan
            ')
            ->from('pembayaran')
            ->join(
                'booking',
                'booking.id = pembayaran.booking_id'
            )
            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id'
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
                'pembayaran.status_pembayaran',
                $status
            );
        }
        return $this->db
            ->order_by(
                'pembayaran.id',
                'DESC'
            )
            ->get()
            ->result();
    }
    public function get_detail($id, $cabang_id)
    {
        return $this->db
            ->select('
                pembayaran.*,
                booking.kode_booking,
                booking.nama_pemesan,
                booking.no_hp_pemesan,
                booking.total_bayar,
                booking.status_booking,
                booking.tanggal_main,
                booking.jam_mulai,
                booking.jam_selesai,
                lapangan.nama_lapangan,
                cabang.nama_cabang
            ')
            ->from('pembayaran')
            ->join(
                'booking',
                'booking.id = pembayaran.booking_id'
            )
            ->join(
                'lapangan',
                'lapangan.id = booking.lapangan_id'
            )
            ->join(
                'cabang',
                'cabang.id = booking.cabang_id'
            )
            ->where(
                'pembayaran.id',
                $id
            )
            ->where(
                'booking.cabang_id',
                $cabang_id
            )
            ->get()
            ->row();
    }

    public function get_riwayat_status($pembayaran_id)
    {
        return $this->db
            ->select('
                riwayat_status_pembayaran.*
            ')
            ->from(
                'riwayat_status_pembayaran'
            )
            ->join(
                'pembayaran',
                'pembayaran.id = riwayat_status_pembayaran.pembayaran_id',
                'left'
            )
            ->where(
                'riwayat_status_pembayaran.pembayaran_id',
                $pembayaran_id
            )
            ->order_by(
                'riwayat_status_pembayaran.id',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('pembayaran')
            ->row();
    }

    public function insert($data)
    {
        $this->db->insert('pembayaran', $data);

        return $this->db->insert_id();
    }
    public function insert_riwayat_pembayaran($data)
    {
        return $this->db->insert('riwayat_status_pembayaran', $data);
        //$this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('pembayaran', $data);
    }

    public function update_status($pembayaran_id, $status)
    {
        return $this->db
            ->where('id', $pembayaran_id)
            ->update('pembayaran', [
                'status_pembayaran' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
    public function update_status_by_booking($booking_id, $data)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->update('pembayaran', $data);
        // ->update('pembayaran', [
        //     'status_pembayaran' => $status
        // ]);
    }
    public function get_by_booking($booking_id)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->get('pembayaran')
            ->row();
    }

    public function get_by_invoice($invoice)
    {
        return $this->db
            ->where('invoice_no', $invoice)
            ->get('pembayaran')
            ->row();
    }

    public function update_status1($booking_id, $status)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->update('pembayaran', [
                'status_pembayaran' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function payment_success($booking_id, $response)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->update('pembayaran', [
                'status_pembayaran' => STATUS_PEMBAYARAN_PAID,
                'raw_response' => json_encode($response),
                'paid_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function payment_cancel($booking_id, $response = null)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->update('pembayaran', [
                'status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED,
                'raw_response' => json_encode($response),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function save_gateway_response($booking_id, $response)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->update('pembayaran', [
                'raw_response' => json_encode($response),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function get_unpaid_expired1()
    {
        return $this->db
            ->select('pembayaran.*,booking.expired_at')
            ->from('pembayaran')
            ->join('booking', 'booking.id=pembayaran.booking_id')
            ->where('status_pembayaran', STATUS_PEMBAYARAN_UNPAID)
            ->where('booking.expired_at <', date('Y-m-d H:i:s'))
            ->get()
            ->result();
    }
    public function get_unpaid_expired()
    {
        return $this->db
            ->select('pembayaran.*,booking.expired_at,booking.total_bayar,booking.invoice_no')
            ->from('pembayaran')
            ->join('booking', 'booking.id=pembayaran.booking_id')
            ->where('pembayaran.status_pembayaran', STATUS_PEMBAYARAN_UNPAID)
            ->where('booking.expired_at <', date('Y-m-d H:i:s'))
            ->get()
            ->result();
    }
}
