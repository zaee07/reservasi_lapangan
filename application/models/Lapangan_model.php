<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapangan_model extends CI_Model
{
    public function get_lapangan_terlaris($cabang_id)
    {
        return $this->db
            ->select('lapangan.nama_lapangan,COUNT(*) as total_booking')
            ->from('booking')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.cabang_id', $cabang_id)
            ->where('MONTH(tanggal_main)', date('m'))
            ->where('YEAR(tanggal_main)', date('Y'))
            ->group_by('booking.lapangan_id')
            ->order_by('total_booking', 'DESC')
            ->limit(5)
            ->get()
            ->result();
    }
    public function get_by_cabang($cabang_id)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->order_by('id', 'DESC')
            ->get('lapangan')
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('lapangan', ['id' => $id])
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert('lapangan', $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('lapangan', $data);
    }

    public function delete($id)
    {
        return $this->db
            ->delete('lapangan', ['id' => $id]);
    }
}
