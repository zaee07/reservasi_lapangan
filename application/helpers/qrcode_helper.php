<?php
defined('BASEPATH') or exit('No direct script access allowed');

function generate_booking_qr($booking_id, $kode_booking)
{
    require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
    $qr_dir = FCPATH . 'uploads/qrcode/';
    if (!is_dir($qr_dir)) {
        mkdir($qr_dir, 0777, true);
    }
    $filename = 'booking_' . $booking_id . '.png';
    $filepath = $qr_dir . $filename;
    $payload = $booking_id . '|' . $kode_booking;
    // $payload = base64_encode($booking_id . '|' . $kode_booking);

    QRcode::png($payload, $filepath, QR_ECLEVEL_H, 10);
    return $filename;
}
