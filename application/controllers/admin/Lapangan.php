<?php
require_once APPPATH . 'core/Admin_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Lapangan extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Lapangan_model', 'lapangan');
        $this->load->model('Jadwal_model', 'jadwal');
        $this->load->model('Pengguna_model', 'pengguna');
    }

    public function index()
    {
        $data = [
            'title'     => 'Lapangan',
            'main_view' => 'admin/lapangan/index',
            'lapangan'  => $this->lapangan->get_by_cabang($this->user['cabang_id'])
        ];

        $this->load->view('templates/header', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Lapangan';
        $data['main_view'] = 'admin/lapangan/create';

        $this->load->view('templates/header', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama_lapangan', 'Nama Lapangan', 'required');
        $this->form_validation->set_rules('jenis_lantai', 'Lantai Lapangan', 'required');
        $this->form_validation->set_rules('jam_buka', 'Jam buka', 'required');
        $this->form_validation->set_rules('jam_tutup', 'Jam tutup', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (!$this->input->post('hari_operasional')) {
                $this->session->set_flashdata('error', 'Pilih minimal 1 hari operasional');
                redirect('lapangan/create');
            }
            $foto1 = $this->upload_foto('foto_1');
            $foto2 = $this->upload_foto('foto_2');
            $foto3 = $this->upload_foto('foto_3');

            $data = [
                'cabang_id'      => $this->user['cabang_id'],
                'nama_lapangan'  => htmlspecialchars($this->input->post('nama_lapangan', true)),
                'jenis_lantai'   => $this->input->post('jenis_lantai'),
                'jam_buka' => $this->input->post('jam_buka'),
                'jam_tutup' => $this->input->post('jam_tutup'),
                'hari_operasional' => implode(',', $this->input->post('hari_operasional')),
                'foto_1'           => $foto1,
                'foto_2'           => $foto2,
                'foto_3'           => $foto3,
                'status'         => $this->input->post('status')
            ];
            $lapangan_id = $this->lapangan->insert($data);
            $this->jadwal->generate_slot_30_hari(
                $lapangan_id,
                $this->user['cabang_id'],
                $this->input->post('jam_buka'),
                $this->input->post('jam_tutup'),
                $this->input->post('hari_operasional')
            );
            $this->session->set_flashdata('success', 'Lapangan berhasil ditambahkan');

            redirect('lapangan');
        }
    }

    private function upload_foto($field)
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $config['upload_path'] = './uploads/lapangan/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field)) {
            return $this->upload->data('file_name');
        }

        return null;
    }

    private function replace_foto($field, $old_file = null)
    {
        if (empty($_FILES[$field]['name'])) {
            return $old_file;
        }

        $config['upload_path']   = './uploads/lapangan/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field)) {

            if (
                $old_file &&
                file_exists('./uploads/lapangan/' . $old_file)
            ) {
                unlink('./uploads/lapangan/' . $old_file);
            }

            return $this->upload->data('file_name');
        }

        return $old_file;
    }

    public function hapus_foto($id, $slot)
    {
        $lapangan = $this->lapangan->get_by_id($id);
        if (!$lapangan || $lapangan->cabang_id != $this->user['cabang_id']) {
            show_error('Akses ditolak', 403);
        }
        if (!in_array($slot, [1, 2, 3])) {
            show_404();
        }
        $field = 'foto_' . $slot;

        if ($lapangan->$field && file_exists('./uploads/lapangan/' . $lapangan->$field)) {
            unlink('./uploads/lapangan/' . $lapangan->$field);
            $this->lapangan->update($id, [$field => null]);
        }

        redirect('lapangan/edit/' . $id);
    }

    public function edit($id)
    {
        $cabang_id = $this->user['cabang_id'];
        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }

        $data = [
            'title'     => 'Edit Lapangan',
            'main_view' => 'admin/lapangan/edit',
            'lapangan'  => $lapangan
        ];

        $this->load->view('templates/header', $data);
    }

    public function update($id)
    {
        $cabang_id = $this->user['cabang_id'];
        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }
        $foto1 = $this->replace_foto('foto_1', $lapangan->foto_1);
        $foto2 = $this->replace_foto('foto_2', $lapangan->foto_2);
        $foto3 = $this->replace_foto('foto_3', $lapangan->foto_3);

        $data = [
            'nama_lapangan' => htmlspecialchars($this->input->post('nama_lapangan', true)),
            'jenis_lantai' => $this->input->post('jenis_lantai'),
            'jam_buka' => $this->input->post('jam_buka'),
            'jam_tutup' => $this->input->post('jam_tutup'),
            'hari_operasional' => implode(',', $this->input->post('hari_operasional')),
            'foto_1' => $foto1,
            'foto_2' => $foto2,
            'foto_3' => $foto3,
            'status' => $this->input->post('status')
        ];

        $this->lapangan->update($id, $data);
        $this->session->set_flashdata('success', 'Lapangan berhasil diupdate');

        redirect('lapangan');
    }

    public function regenerate_slot($id)
    {
        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan) {
            show_404();
        }
        // var_dump($lapangan);
        // die();

        $this->jadwal->generate_slot_30_hari(
            $lapangan->id,
            $lapangan->cabang_id,
            $lapangan->jam_buka,
            $lapangan->jam_tutup,
            explode(',', $lapangan->hari_operasional)
        );

        $this->session->set_flashdata('success', 'Slot berhasil digenerate ulang');

        redirect('lapangan/edit/' . $id);
    }

    public function delete($id)
    {
        $cabang_id = $this->user['cabang_id'];
        $lapangan = $this->lapangan->get_by_id($id);

        if (!$lapangan || $lapangan->cabang_id != $cabang_id) {
            show_error('Akses ditolak!', 403);
        }
        $aktif_booking = $this->db
            ->where('lapangan_id', $id)
            ->where_in('status_booking', [
                STATUS_BOOKING_PENDING,
                STATUS_BOOKING_CONFIRMED,
                STATUS_BOOKING_CHECKIN
            ])
            ->count_all_results('booking');

        if ($aktif_booking > 0) {
            $this->session->set_flashdata('error', 'Masih ada booking aktif pada lapangan ini');
            redirect('lapangan');
        }

        $this->lapangan->nonaktif($id);
        $this->session->set_flashdata('success', 'Lapangan berhasil dinonaktifkan!');

        redirect('lapangan');
    }
}
