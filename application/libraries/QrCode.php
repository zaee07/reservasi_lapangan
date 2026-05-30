<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QrCode
{

    public function __construct()
    {
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
}
