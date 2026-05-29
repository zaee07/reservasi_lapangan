<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{

    public function get_jadwal($cabang_id, $tanggal)
    {
        return $this->db
            ->select('
                jadwal_slot.*,
                lapangan.nama_lapangan
            ')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->where('jadwal_slot.cabang_id', $cabang_id)
            ->where('jadwal_slot.tanggal', $tanggal)
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
    }

    public function get_lapangan($cabang_id)
    {
        return $this->db
            ->where('cabang_id', $cabang_id)
            ->where('status', 'aktif')
            ->get('lapangan')
            ->result();
    }

    public function cek_slot($lapangan_id, $tanggal, $jam_mulai)
    {
        return $this->db
            ->get_where('jadwal_slot', [
                'lapangan_id' => $lapangan_id,
                'tanggal'     => $tanggal,
                'jam_mulai'   => $jam_mulai
            ])
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert('jadwal_slot', $data);
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('jadwal_slot', ['id' => $id])
            ->row();
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('jadwal_slot', $data);
    }

    public function get_cabang()
    {
        return $this->db
            ->where('status', 'aktif')
            ->get('cabang')
            ->result();
    }

    public function get_jadwal_by_tgl($tanggal, $kode_cabang)
    {
        return $this->db
            ->select('
                jadwal_slot.*,
                lapangan.nama_lapangan,
                cabang.nama_cabang
            ')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->join('cabang', 'cabang.id = jadwal_slot.cabang_id')
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('cabang.kode_cabang', $kode_cabang)
            ->order_by('lapangan.nama_lapangan', 'ASC')
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
    }
    public function get_jadwal_slot_by_tgl($tanggal, $kode_cabang)
    {
        $result = $this->db
            ->select('jadwal_slot.*,lapangan.nama_lapangan,cabang.nama_cabang')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->join('cabang', 'cabang.id = jadwal_slot.cabang_id')
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('cabang.kode_cabang', $kode_cabang)
            ->where('jadwal_slot.status_slot !=', STATUS_SLOT_CLOSED)
            ->order_by('cabang.nama_cabang', 'ASC')
            ->order_by('lapangan.nama_lapangan', 'ASC')
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
        $grouped = [];
        foreach ($result as $row) {
            $grouped[$row->nama_cabang][$row->nama_lapangan][] = $row;
        }
        return $grouped;
    }
}
