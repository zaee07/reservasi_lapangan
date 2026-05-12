<?php
class Pengguna_model extends CI_Model
{
    private $table = 'user';

    public function get_by_email($email)
    {
        return $this->db
            ->select('user.*, role.nama_role')
            ->from($this->table)
            ->join('role', 'role.id = user.role_id')
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
