<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{

    public function get_jadwal($cabang_id, $tanggal, $lapangan_id = null)
    {
        $this->db
            ->select('
                jadwal_slot.*,
                lapangan.nama_lapangan
            ')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->where('jadwal_slot.cabang_id', $cabang_id)
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('lapangan.status', 'aktif');
        if ($lapangan_id) {
            $this->db->where('lapangan_id', $lapangan_id);
        }
        return $this->db->order_by('jadwal_slot.jam_mulai', 'ASC')
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

    public function get_jadwal_by_tgl($tanggal, $kode_cabang = null)
    {
        $this->db
            ->select('jadwal_slot.*,lapangan.nama_lapangan,cabang.nama_cabang')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->join('cabang', 'cabang.id = jadwal_slot.cabang_id')
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('lapangan.status !=', 'nonaktif');
        if ($kode_cabang) {
            $this->db->where('cabang.kode_cabang', $kode_cabang);
        }
        return $this->db
            ->order_by('cabang.nama_cabang')
            ->order_by('lapangan.nama_lapangan', 'ASC')
            ->order_by('jadwal_slot.jam_mulai', 'ASC')
            ->get()
            ->result();
    }

    public function get_jadwal_slot_tgl($tanggal, $kode_cabang = null)
    {
        $this->db
            ->select('jadwal_slot.*,lapangan.nama_lapangan,cabang.nama_cabang')
            ->from('jadwal_slot')
            ->join('lapangan', 'lapangan.id = jadwal_slot.lapangan_id')
            ->join('cabang', 'cabang.id = jadwal_slot.cabang_id')
            ->where('jadwal_slot.tanggal', $tanggal)
            ->where('lapangan.status !=', 'nonaktif');
        if ($kode_cabang) {
            $this->db->where('cabang.kode_cabang', $kode_cabang);
        }
        $result = $this->db
            ->order_by('cabang.nama_cabang')
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
            ->where('lapangan.status !=', 'nonaktif')
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

    public function generate_slot_30_hari($lapangan_id, $cabang_id, $jam_buka, $jam_tutup, $hari_operasional)
    {
        for ($i = 0; $i < 30; $i++) {
            $tanggal = date('Y-m-d', strtotime("+$i days"));
            $hari = date('w', strtotime($tanggal));

            if (!in_array($hari, $hari_operasional)) {
                continue;
            }
            $start = strtotime($jam_buka);
            $end   = strtotime($jam_tutup);
            while ($start < $end) {
                $jam_mulai = date('H:i:s', $start);
                $next = strtotime('+1 hour', $start);
                $jam_selesai = date('H:i:s', $next);
                $cek = $this->db
                    ->where('lapangan_id', $lapangan_id)
                    ->where('tanggal', $tanggal)
                    ->where('jam_mulai', $jam_mulai)
                    ->count_all_results('jadwal_slot');

                if (!$cek) {
                    $this->db->insert(
                        'jadwal_slot',
                        [
                            'cabang_id'   => $cabang_id,
                            'lapangan_id' => $lapangan_id,
                            'tanggal'     => $tanggal,
                            'jam_mulai'   => $jam_mulai,
                            'jam_selesai' => $jam_selesai,
                            'status_slot' => STATUS_SLOT_AVAILABLE
                        ]
                    );
                }
                $start = $next;
            }
        }
    }
}
