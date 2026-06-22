<?php
require_once APPPATH . 'core/Owner_Controller.php';

class Member extends Owner_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Riwayat_model', 'riwayat');
    }

    public function index()
    {
        $keyword = $this->input->get('keyword');
        $data = [
            'title'      => 'Data Member',
            'active'     => 'member',
            'main_view'  => 'owner/member/index',
            'members'    => $this->pengguna->get_member_owner($keyword),
            'total_member' => $this->pengguna->get_total_member()
        ];
        $this->load->view('templates/header', $data);
    }

    public function detail($id)
    {
        $member = $this->pengguna->get_by_id($id);
        if (!$member) {
            show_404();
        }
        $data = [
            'title'     => 'Detail Member',
            'active'    => 'member',
            'main_view' => 'owner/member/detail',
            'member'    => $member,
            'riwayat'   => $this->riwayat->get_by_user($id)
        ];
        $this->load->view('templates/header', $data);
    }
}
