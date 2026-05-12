<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapangan_model extends CI_Model
{

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
