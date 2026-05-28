<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $CI = get_instance();
        if (!$CI->session->userdata('logged_in')) {
            redirect('auth');
        }
    }
}
if (!function_exists('redirect_by_role')) {
    function redirect_by_role($role)
    {
        switch ($role) {
            case 'owner':
                return redirect('owner/dashboard');
            case 'admin_cabang':
                return redirect('admin/dashboard');
            case 'petugas':
                return redirect('petugas/dashboard');
            case 'member':
                return redirect('home');
            default:
                return redirect('auth');
        }
    }
}

if (!function_exists('check_role')) {
    function check_role($role_allowed)
    {
        $CI = get_instance();
        if ($CI->session->userdata('nama_role') != $role_allowed) {
            redirect('auth');
        }
        // $user_role = $CI->session->userdata('role_id');
        // if (!in_array($user_role, (array)$role_id_allowed)) {
        //     // show_error('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.', 403, 'Forbidden');
        //     $CI->output->set_status_header(403);
        //     $CI->load->view('errors/html/error_403');
        //     echo $CI->output->get_output();
        //     exit;
        // }
    }
}

if (!function_exists('has_role')) {
    /**
     *
     * @param array|int $role_id_allowed
     * @return bool
     */
    function has_role($role_id_allowed)
    {
        $CI = get_instance();
        $user_role = $CI->session->userdata('role_id');
        return in_array($user_role, (array)$role_id_allowed);
    }
}
if (!function_exists('foto_user')) {
    function foto_user($foto = null)
    {
        if ($foto && file_exists('./uploads/user/' . $foto)) {
            return base_url('uploads/user/' . $foto);
        }

        return base_url('assets/img/avatars/def.png');
    }
}
