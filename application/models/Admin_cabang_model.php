<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_cabang_model extends CI_Model
{

    public function get_all()
    {
        return $this->db
            ->select('
                user.*,
                cabang.nama_cabang,
                role.nama_role
            ')
            ->from('user')
            ->join('cabang', 'cabang.id = user.cabang_id', 'left')
            ->join('role', 'role.id = user.role_id')
            ->where('user.role_id', 2)
            ->order_by('user.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('user', [
                'id' => $id,
                'role_id' => 2
            ])
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert('user', $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('user', $data);
    }

    public function delete($id)
    {
        return $this->db
            ->delete('user', ['id' => $id]);
    }

    public function get_cabang()
    {
        return $this->db
            ->where('status', 'aktif')
            ->get('cabang')
            ->result();
    }
}
