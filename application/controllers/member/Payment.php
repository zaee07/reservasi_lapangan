<?php
require_once APPPATH . 'core/Member_Controller.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Booking_model', 'booking');
        $this->load->model('Pembayaran_model', 'pembayaran');
        $this->load->library('pakasir');
    }

    public function index($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);
        $pembayaran = $this->pembayaran->get_by_booking($booking_id);

        if (!$booking) {
            show_404();
        }

        if ($booking->user_id != $this->user['id']) {
            show_error('Akses ditolak', 403);
        }

        if (!$pembayaran) {
            show_error('Data pembayaran tidak ditemukan');
        }
        if (empty($pembayaran->raw_response)) {
            $gateway = $this->pakasir->create_transaction($pembayaran->invoice_no, (int) $booking->total_bayar);

            if (!$gateway['success']) {
                $this->session->set_flashdata('error', 'Gagal membuat transaksi QRIS.');
                redirect('member/riwayat/detail/' . $booking_id);
                return;
            }
            $this->load->helper('payment');

            $qr_file = generate_qris(
                $gateway['response']['payment']['payment_number'],
                $pembayaran->invoice_no
            );
            $this->pembayaran->update(
                $pembayaran->id,
                [
                    'qr_image'      => $qr_file,
                    'raw_response' => json_encode($gateway['response'])
                ]
            );
            redirect('payment/' . $booking_id);
            return;
        }

        $pembayaran = $this->pembayaran->get_by_booking($booking_id);

        $data = [
            'title'       => 'Pembayaran',
            'active'      => 'booking',
            'main_view'   => 'user/payment/index',
            'booking'     => $booking,
            'pembayaran'  => $pembayaran
        ];

        $this->load->view('templates/user_header', $data);
    }
    public function create($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);
        if (!$booking) {
            show_404();
        }

        $pembayaran = $this->pembayaran->get_by_booking($booking_id);
        if (!$pembayaran) {
            show_error('Data pembayaran tidak ditemukan');
        }
        if ($pembayaran->status_pembayaran != STATUS_PEMBAYARAN_UNPAID) {
            redirect('payment/index/' . $booking_id);
        }

        $result = $this->pakasir->create_transaction($pembayaran->invoice_no, $pembayaran->nominal);

        if (!$result['success']) {
            $this->session->set_flashdata('error', 'Gagal membuat transaksi');

            redirect('payment/index/' . $booking_id);
        }

        $this->pembayaran->save_gateway_response($booking_id, $result['response']);
        redirect('payment/index/' . $booking_id);
    }
    public function check($booking_id)
    {
        $booking = $this->booking->get_booking_by_id($booking_id);

        if (!$booking) {
            show_404();
        }

        if ($booking->user_id != $this->user['id']) {
            show_error('Akses ditolak', 403);
        }

        $pembayaran = $this->pembayaran->get_by_booking($booking_id);

        if (!$pembayaran) {
            show_error('Data pembayaran tidak ditemukan');
        }

        if ($pembayaran->status_pembayaran == STATUS_PEMBAYARAN_PAID) {
            redirect('payment/' . $booking_id);
        }

        $gateway = $this->pakasir->detail_transaction($pembayaran->invoice_no, $booking->total_bayar);

        if (!empty($gateway['response'])) {
            $this->pembayaran->save_gateway_response($booking_id, $gateway['response']);
        }

        if (!$gateway['success']) {
            $this->session->set_flashdata('error', 'Gagal menghubungi Payment Gateway.');

            redirect('payment/' . $booking_id);
        }

        $status = strtolower($gateway['response']['transaction']['status'] ?? '');

        if ($status == 'completed') {
            $this->db->trans_start();
            $this->booking->update_booking_status($booking_id, STATUS_BOOKING_CONFIRMED);
            $this->pembayaran->payment_success($booking_id, $gateway['response']);
            if ($pembayaran->status_pembayaran != STATUS_PEMBAYARAN_PAID) {
                $this->load->helper('qrcode');
                $qr_code = generate_booking_qr($booking_id, $booking->kode_booking);

                $this->booking->update_booking($booking_id, ['qr_booking' => $qr_code, 'confirmed_at' => date('Y-m-d H:i:s')]);
                $this->booking->insert_status_history([
                    'booking_id'          => $booking_id,
                    'status_booking'      => STATUS_BOOKING_CONFIRMED,
                    'keterangan'          => 'Booking dibayarkan'
                ]);
                $this->pembayaran->insert_riwayat_pembayaran([
                    'pembayaran_id' => $pembayaran->id,
                    'status_pembayaran' => STATUS_PEMBAYARAN_PAID,
                    'keterangan' => 'Pembayaran QRIS berhasil',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->db->trans_complete();
            $this->session->set_flashdata('success', 'Pembayaran berhasil.');
        }

        redirect('payment/' . $booking_id);
    }

    public function cancel($booking_id) {}
    public function ajax_status($invoice)
    {
        // echo $invoice;
        $payment = $this->pembayaran->get_by_invoice($invoice);
        if (!$payment) {
            echo json_encode(['status' => 'not_found']);
            return;
        }
        $booking = $this->booking->get_booking_by_id($payment->booking_id);
        // var_dump($payment);
        // var_dump($booking);
        $gateway = $this->pakasir->detail_transaction($payment->invoice_no, $payment->nominal);
        if ($gateway['success'] && isset($gateway['response']['transaction'])) {
            $trx = $gateway['response']['transaction'];
            if ($trx['status'] == 'completed') {
                $this->db->trans_start();
                $this->booking->update_booking_status($payment->booking_id, STATUS_BOOKING_CONFIRMED);
                $this->booking->insert_status_history([
                    'booking_id'          => $payment->booking_id,
                    'status_booking'      => STATUS_BOOKING_CONFIRMED,
                    'keterangan'          => 'Booking terkonfirmasi sistem'
                ]);
                $this->load->helper('qrcode');
                $qr_code = generate_booking_qr($payment->booking_id, $booking->kode_booking);
                $this->booking->update_booking($payment->booking_id, ['qr_booking' => $qr_code, 'confirmed_at' => date('Y-m-d H:i:s')]);
                $this->pembayaran->payment_success($payment->booking_id, $gateway['response']);
                if ($payment->status_pembayaran != STATUS_PEMBAYARAN_PAID) {
                    $this->pembayaran->insert_riwayat_pembayaran([
                        'pembayaran_id' => $payment->id,
                        'status_pembayaran' => STATUS_PEMBAYARAN_PAID,
                        'keterangan' => 'Pembayaran berhasil'
                    ]);
                }
                $this->db->trans_complete();
                echo json_encode(['status' => 'paid']);
                return;
            }
        }

        if (strtotime($payment->expired_at) < time()) {
            $booking = $this->booking->get_booking_by_id($payment->booking_id);
            if (!$booking) {
                show_404();
            }
            $this->db->trans_start();
            $this->booking->update_booking_status($payment->booking_id, STATUS_BOOKING_EXPIRED);
            $this->booking->insert_status_history([
                'booking_id'          => $payment->booking_id,
                'status_booking'      => STATUS_BOOKING_EXPIRED,
                'keterangan'          => 'Booking expired'
            ]);
            $pembayaran = $this->pembayaran->get_by_invoice($invoice);
            if ($pembayaran) {
                $result = $this->pakasir->cancel_transaction($pembayaran->invoice_no, $booking->total_bayar);
                if (in_array($pembayaran->status_pembayaran, [STATUS_PEMBAYARAN_UNPAID])) {
                    $this->pembayaran->payment_cancel($payment->booking_id, json_encode($result));
                    $this->pembayaran->insert_riwayat_pembayaran([
                        'pembayaran_id'     => $pembayaran->id,
                        'status_pembayaran' => STATUS_PEMBAYARAN_EXPIRED,
                        'keterangan'        => 'Booking dibatalkan karena Pembayaran expired'
                    ]);
                }
            }
            $this->booking->release_slot($payment->booking_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $this->session->set_flashdata('error', 'Gagal membatalkan booking');
            } else {
                $this->session->set_flashdata('success', 'Booking berhasil dibatalkan');
            }
            echo json_encode(['status' => 'expired']);
            return;
        }
        echo json_encode(['status' => 'unpaid']);
    }

    public function success($invoice)
    {
        $payment = $this->pembayaran->get_by_invoice($invoice);
        if (!$payment) {
            show_404();
        }
        $booking = $this->booking->get_booking_by_id($payment->booking_id);
        $data = [
            'title' => 'Pembayaran Berhasil',
            'active' => 'riwayat_booking',
            'main_view' => 'user/payment/succes',
            'booking' => $booking,
            'payment' => $payment
        ];
        $this->load->view('templates/user_header', $data);
    }

    // public function expired()
    // {
    //     $list = $this->pembayaran->get_unpaid_expired();

    //     if (empty($list)) {

    //         echo 'Tidak ada pembayaran expired';

    //         return;
    //     }

    //     foreach ($list as $row) {

    //         /*
    //     ---------------------------------------
    //     Cancel Gateway
    //     ---------------------------------------
    //     */

    //         $gateway = $this->pakasir->cancel_transaction(

    //             $row->invoice_no,

    //             $row->nominal

    //         );

    //         $this->db->trans_start();

    //         /*
    //     ---------------------------------------
    //     Booking
    //     ---------------------------------------
    //     */

    //         $this->booking->payment_expired(
    //             $row->booking_id
    //         );

    //         /*
    //     ---------------------------------------
    //     Pembayaran
    //     ---------------------------------------
    //     */

    //         $this->pembayaran->payment_cancel(

    //             $row->booking_id,

    //             $gateway['response']

    //         );

    //         /*
    //     ---------------------------------------
    //     Release Slot
    //     ---------------------------------------
    //     */

    //         $this->booking->release_slot(

    //             $row->booking_id

    //         );

    //         /*
    //     ---------------------------------------
    //     History
    //     ---------------------------------------
    //     */

    //         $this->pembayaran->insert_riwayat_pembayaran([

    //             'pembayaran_id' => $row->id,

    //             'status' => STATUS_PEMBAYARAN_EXPIRED,

    //             'keterangan' => 'Expired otomatis',

    //             'created_at' => date('Y-m-d H:i:s')

    //         ]);

    //         $this->db->trans_complete();

    //         log_message(

    //             'info',

    //             'Expired : ' . $row->invoice_no

    //         );
    //     }
    //     $data['title'] = "Pembayaran Expired";

    //     $this->load->view(
    //         'member/payment_expired',
    //         $data
    //     );

    //     echo "Selesai";
    // }
}
