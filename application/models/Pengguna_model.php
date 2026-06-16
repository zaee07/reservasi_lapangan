<?php
class Pengguna_model extends CI_Model
{
    private $table = 'user';
    public function get_total_member()
    {
        return $this->db
            ->where('role_id', 4)
            ->count_all_results($this->table);
    }
    public function get_by_email($email)
    {
        return $this->db
            ->select('user.*, role.nama_role, cabang.nama_cabang, cabang.kode_cabang')
            ->from($this->table)
            ->join('role', 'role.id = user.role_id')
            ->join('cabang', 'cabang.id = user.cabang_id', 'left')
            ->where('user.email', $email)
            ->get()
            ->row_array();
    }

    public function get_admin_cabang_by_id($id)
    {
        return $this->db
            ->get_where('user', [
                'id' => $id,
                'role_id' => 2
            ])
            ->row();
    }

    public function get_user_cabang_by_id($id)
    {
        return $this->db
            ->select('user.*, cabang.nama_cabang')
            ->from('user')
            ->join('cabang', 'cabang.id = user.cabang_id')
            ->where('user.id', $id)
            ->get()
            ->row();
    }

    public function insert_user($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}
