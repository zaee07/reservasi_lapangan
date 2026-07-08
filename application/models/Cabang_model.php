<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_model extends CI_Model
{

    private $table = 'cabang';

    public function get_all()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_total_cabang()
    {
        return $this->db->count_all($this->table);
    }

    public function get_ranking_cabang()
    {
        return $this->db
            ->select('cabang.nama_cabang,COUNT(booking.id) total_booking')
            ->from('cabang')
            ->where_not_in('status_booking', [STATUS_BOOKING_CANCELLED, STATUS_BOOKING_EXPIRED])
            ->join('booking', 'booking.cabang_id = cabang.id', 'left')
            ->group_by('cabang.id')
            ->order_by('total_booking', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where($this->table, ['id' => $id])
            ->row();
    }

    public function get_by_kode($kode)
    {
        return $this->db
            ->get_where($this->table, ['kode_cabang' => $kode])
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->delete($this->table, ['id' => $id]);
    }
}
