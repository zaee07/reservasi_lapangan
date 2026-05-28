<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_model extends CI_Model
{

    private $table = 'cabang';

    public function get_all()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get($this->table)
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
