<?php
defined('BASEPATH') or exit('No direct script access allowed');

function generate_qris($payload, $invoice)
{
    require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

    $dir = FCPATH . 'uploads/payment/';

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $filename = 'payment_' . $invoice . '.png';

    QRcode::png(
        $payload,
        $dir . $filename,
        QR_ECLEVEL_M,
        10
    );

    return $filename;
}
