<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'home';
$route['404_override'] = '';
$route['error_403'] = 'errors/html/error_403';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'auth';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['cron/expired-booking'] = 'cron/expired_booking';
$route['cron/completed-booking'] = 'cron/complete_booking';

/**
 * route member
 */
$route['home'] = 'member/home/index';
$route['jadwal_lapangan'] = 'member/jadwal/index';
$route['booking']        = 'member/booking/index';
$route['booking/proses']      = 'member/booking/proses';
$route['booking/sukses/(:num)'] = 'member/booking/sukses/$1';
$route['riwayat_booking'] = 'member/riwayat/index';
$route['riwayat_booking/detail/(:num)'] = 'member/riwayat/detail/$1';
$route['riwayat_booking/cancel/(:num)'] = 'member/riwayat/cancel/$1';
$route['booking_detail/download_qr/(:num)'] = 'member/riwayat/download_qr/$1';
$route['booking_detail/download_pdf/(:num)'] = 'member/riwayat/download_pdf/$1';
$route['profile'] = 'member/profile/index';
$route['profile/edit'] = 'member/profile/edit';
$route['profile/hapus_foto'] = 'member/profile/hapus_foto';
$route['profile/ubah_password'] = 'member/profile/ubah_password';
// $route['pembayaran/(:num)'] = 'pembayaran/index/$1';
// $route['riwayat'] = 'riwayat/index';
// $route['jadwal'] = 'jadwal/index';
/**
 * route admin
 */
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['lapangan'] = 'admin/lapangan/index';
$route['lapangan/create']          = 'admin/lapangan/create';
$route['lapangan/store']           = 'admin/lapangan/store';
$route['lapangan/edit/(:num)']     = 'admin/lapangan/edit/$1';
$route['lapangan/update/(:num)']   = 'admin/lapangan/update/$1';
$route['lapangan/delete/(:num)']   = 'admin/lapangan/delete/$1';
$route['jadwal']                     = 'admin/jadwal/index';
$route['jadwal/generate']            = 'admin/jadwal/generate';
$route['jadwal/store_generate']      = 'admin/jadwal/store_generate';
$route['jadwal/edit/(:num)']         = 'admin/jadwal/edit/$1';
$route['jadwal/update/(:num)']       = 'admin/jadwal/update/$1';
$route['admin/reservasi'] = 'admin/reservasi/index';
$route['admin/reservasi/detail/(:num)'] = 'admin/reservasi/detail/$1';
$route['admin/reservasi/confirm/(:num)'] = 'admin/reservasi/confirm/$1';
$route['admin/transaksi'] = 'admin/transaksi/index';
$route['admin/transaksi/detail/(:num)'] = 'admin/transaksi/detail/$1';
$route['petugas_cabang']                 = 'admin/petugas_cabang/index';
$route['petugas_cabang/create']          = 'admin/petugas_cabang/create';
$route['petugas_cabang/store']           = 'admin/petugas_cabang/store';
$route['petugas_cabang/edit/(:num)']     = 'admin/petugas_cabang/edit/$1';
$route['petugas_cabang/update/(:num)']   = 'admin/petugas_cabang/update/$1';
$route['petugas_cabang/password/(:num)']   = 'admin/petugas_cabang/password/$1';
$route['petugas_cabang/delete/(:num)']   = 'admin/petugas_cabang/delete/$1';
$route['admin/laporan'] = 'admin/laporan/index';
$route['admin/laporan/export-pdf'] = 'admin/laporan/export_pdf';
$route['admin/laporan/export-excel'] = 'admin/laporan/export_excel';
// $route['admin/pembayaran'] = 'admin/pembayaran/index';
// $route['admin/user'] = 'admin/user/index';

/**
 * route petugas
 */
$route['petugas'] = 'petugas/dashboard';
$route['petugas/dashboard'] = 'petugas/dashboard';
$route['cek_jadwal'] = 'petugas/jadwal/index';
$route['checkin'] = 'petugas/checkin/index';
$route['walkin'] = 'petugas/walkin';
$route['petugas/walkin'] = 'petugas/walkin';
$route['petugas/walkin/proses'] = 'petugas/walkin/proses';
$route['petugas/walkin/simpan'] = 'petugas/walkin/simpan';
$route['petugas/walkin/get_member'] = 'petugas/walkin/get_member';
$route['riwayat'] = 'petugas/riwayat';
$route['riwayat/detail/(:num)'] = 'petugas/riwayat/detail/$1';

/**
 * route owner
 */
$route['owner_dashboard'] = 'owner/dashboard';

$route['cabang'] = 'owner/cabang/index';
$route['cabang/create'] = 'owner/cabang/create';
$route['cabang/store'] = 'owner/cabang/store';
$route['cabang/edit/(:num)'] = 'owner/cabang/edit/$1';
$route['cabang/update/(:num)'] = 'owner/cabang/update/$1';
$route['cabang/delete/(:num)'] = 'owner/cabang/delete/$1';

$route['admin_cabang']                 = 'owner/admin_cabang/index';
$route['admin_cabang/create']          = 'owner/admin_cabang/create';
$route['admin_cabang/store']           = 'owner/admin_cabang/store';
$route['admin_cabang/edit/(:num)']     = 'owner/admin_cabang/edit/$1';
$route['admin_cabang/update/(:num)']   = 'owner/admin_cabang/update/$1';
$route['admin_cabang/password/(:num)']   = 'owner/admin_cabang/password/$1';
$route['admin_cabang/delete/(:num)']   = 'owner/admin_cabang/delete/$1';
$route['owner/laporan'] = 'owner/laporan/index';
$route['owner/laporan/export-pdf'] = 'owner/laporan/export_pdf';
$route['owner/laporan/export-excel'] = 'owner/laporan/export_excel';
// $route['owner/laporan'] = 'owner/laporan/index';
// $route['owner/pengaturan'] = 'owner/pengaturan/index';
// $route['owner/promo'] = 'owner/promo/index';
// $route['owner/admin'] = 'owner/admin/index';