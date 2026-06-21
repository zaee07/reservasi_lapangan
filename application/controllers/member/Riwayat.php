<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Riwayat_model', 'riwayat');
    }

    public function index()
    {
        $data = [
            'title'      => 'Riwayat Booking',
            'active'     => 'riwayat_booking',
            'main_view'  => 'user/riwayat/index',
            'riwayat'    => $this->riwayat->get_by_user($this->user['id'])
        ];
        $this->load->view('templates/user_header', $data);
    }

    public function detail($booking_id = null)
    {
        $booking = $this->riwayat->get_detail_booking($booking_id, $this->user['id']);
        if (!$booking) {
            show_404();
        }
        $data = [
            'title'      => 'Detail Booking',
            'active'     => 'riwayat_booking',
            'main_view'  => 'user/riwayat/detail',
            'booking'    => $booking,
            'slots'      => $this->riwayat->get_booking_slots($booking_id),
            'pembayaran' => $this->riwayat->get_pembayaran($booking_id),
            'riwayat_booking' => $this->riwayat->get_riwayat_booking($booking_id),
            'riwayat_pembayaran' => $this->riwayat->get_riwayat_pembayaran($booking_id)
        ];
        $this->load->view('templates/user_header', $data);
    }

    public function cancel($booking_id = null)
    {
        $booking = $this->riwayat->get_detail_booking($booking_id, $this->user['id']);
        if (!$booking) {
            show_404();
        }
        // hanya pending
        if ($booking->status_booking != 'pending') {
            $this->session->set_flashdata('error', 'Booking tidak dapat dibatalkan');
            return redirect('member/riwayat');
        }
        $this->db->trans_start();
        // update booking
        $this->riwayat->update_booking(
            $booking_id,
            ['status_booking' => 'cancelled', 'cancelled_at'   => date('Y-m-d H:i:s')]
        );
        // insert riwayat status booking
        $this->riwayat->insert_status_history([
            'booking_id'          => $booking_id,
            'status_booking'      => 'cancelled',
            'keterangan'          => 'Booking dibatalkan member',
            'diubah_oleh_user_id' => $this->user['id']
        ]);
        // update pembayaran jika ada
        $pembayaran = $this->riwayat
            ->get_pembayaran($booking_id);
        if ($pembayaran) {
            // hanya update jika belum paid
            if (
                in_array(
                    $pembayaran->status_pembayaran,
                    ['unpaid', 'pending']
                )
            ) {
                $this->riwayat->update_pembayaran(
                    $pembayaran->id,
                    [
                        'status_pembayaran' => 'expired'
                    ]
                );
                // riwayat pembayaran
                $this->riwayat->insert_riwayat_pembayaran([
                    'pembayaran_id'     => $pembayaran->id,
                    'status_pembayaran' => 'expired',
                    'keterangan'        => 'Booking dibatalkan karena Pembayaran expired'
                ]);
            }
        }
        // buka slot kembali
        $this->riwayat->release_slot($booking_id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Gagal membatalkan booking');
        } else {
            $this->session->set_flashdata('success', 'Booking berhasil dibatalkan');
        }
        return redirect('member/riwayat');
    }
}
