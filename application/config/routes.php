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

// $route['home'] = 'home/index';
// $route['jadwal'] = 'jadwal/index';
$route['jadwal_lapangan'] = 'member/jadwal/index';
// $route['booking'] = 'booking/index';
// $route['booking/detail/(:num)'] = 'booking/detail/$1';
// $route['pembayaran/(:num)'] = 'pembayaran/index/$1';
// $route['riwayat'] = 'riwayat/index';
// $route['profil'] = 'profil/index';

$route['admin_cabang_dashboard'] = 'admin/dashboard';
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
// $route['admin/booking'] = 'admin/booking/index';
// $route['admin/pembayaran'] = 'admin/pembayaran/index';
// $route['admin/user'] = 'admin/user/index';

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
$route['admin_cabang/delete/(:num)']   = 'owner/admin_cabang/delete/$1';
// $route['owner/laporan'] = 'owner/laporan/index';
// $route['owner/pengaturan'] = 'owner/pengaturan/index';
// $route['owner/promo'] = 'owner/promo/index';
// $route['owner/admin'] = 'owner/admin/index';