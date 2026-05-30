<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrcode extends CI_Controller
{

    public function index()
    {
        $this->load->library('qrCode');
        $this->session->userdata();

        header('Content-Type: image/png');

        QRcode::png('Hello CI3 PHP7.4');
    }
}
