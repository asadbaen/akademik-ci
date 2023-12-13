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
$route['default_controller'] = 'login';
// siswa
$route['siswa'] = 'siswacontroller';
$route['siswa-create'] = 'siswacontroller/createSiswa';
$route['save-siswa-create'] = 'siswacontroller/saveCreateSiswa';
$route['siswa-edit/(:any)'] = 'siswacontroller/edit/$1';
$route['siswa-simpan-edit'] = 'siswacontroller/saveUpdate';
$route['siswa-detail/(:any)'] = 'siswacontroller/detail/$1';
$route['siswa-delete/(:any)'] = 'siswacontroller/delete/$1';
// guru
$route['guru'] = 'gurucontroller';
$route['guru-create'] = 'gurucontroller/createGuru';
$route['save-guru-create'] = 'gurucontroller/saveCreateGuru';
$route['guru-detail/(:any)'] = 'gurucontroller/detail/$1';
$route['guru-edit/(:any)'] = 'gurucontroller/edit/$1';
$route['guru-simpan-edit'] = 'gurucontroller/saveUpdate';
$route['guru-delete/(:any)'] = 'gurucontroller/delete/$1';
// kepala sekolah
$route['kepala'] = 'KepalaController';
$route['kepala-create'] = 'KepalaController/createKepala';
$route['save-kepala-create'] = 'KepalaController/saveCreateKepala';
$route['kepala-detail/(:any)'] = 'KepalaController/detail/$1';
$route['kepala-edit/(:any)'] = 'KepalaController/edit/$1';
$route['kepala-simpan-edit'] = 'KepalaController/saveUpdate';
$route['kepala-delete/(:any)'] = 'KepalaController/delete/$1';
// admin
$route['admin'] = 'admin/dashboard';
$route['admin-create'] = 'Admin/createAdmin';
$route['save-admin-create'] = 'Admin/saveCreateAdmin';
$route['admin-detail/(:any)'] = 'Admin/detail/$1';
$route['admin-edit/(:any)'] = 'Admin/edit/$1';
$route['admin-simpan-edit'] = 'Admin/saveUpdate';
$route['admin-delete/(:any)'] = 'Admin/delete/$1';
// kelas
$route['kelas'] = 'KelasController';
$route['kelas-create'] = 'KelasController/createKelas';
$route['save-kelas-create'] = 'KelasController/saveCreateKelas';
$route['kelas-detail/(:any)'] = 'KelasController/detail/$1';
$route['kelas-edit/(:any)'] = 'KelasController/edit/$1';
$route['kelas-simpan-edit'] = 'KelasController/saveUpdate';
$route['kelas-delete/(:any)'] = 'KelasController/delete/$1';
//mapel
$route['mapel'] = 'MapelController';
$route['mapel-create'] = 'MapelController/create';
$route['save-mapel-create'] = 'MapelController/saveMapel';
$route['mapel-detail/(:any)'] = 'MapelController/detail/$1';
$route['mapel-edit/(:any)'] = 'MapelController/edit/$1';
$route['mapel-simpan-edit'] = 'MapelController/saveUpdate';
$route['mapel-delete/(:any)'] = 'MapelController/delete/$1';
//jadwal
$route['jadwal'] = 'JadwalController';
$route['jadwal-create'] = 'JadwalController/create';
$route['save-jadwal-create'] = 'JadwalController/saveJadwal';
$route['jadwal-detail/(:any)'] = 'JadwalController/detail/$1';
$route['jadwal-edit/(:any)'] = 'JadwalController/edit/$1';
$route['jadwal-simpan-edit'] = 'JadwalController/saveUpdate';
$route['jadwal-delete/(:any)'] = 'JadwalController/delete/$1';
// students_by_class
$route['students_by_class/(:any)'] = 'SiswaKelas/students_by_class/$1';
// isi presensi
// $route['isi_presensi/(:any)'] = 'Presensi/isiPresensi/$1';
$route['isi_presensi/(:any)'] = 'Presensi/absensi/$1';

//guru kelas siswa
$route['guru-kelas'] = 'GuruKelas/index';
$route['tambah-guru-kelas'] = 'GuruKelas/tambah_kelas_siswa';
$route['simpan-guru-kelas'] = 'GuruKelas/simpan_kelas_siswa';
$route['edit-guru-kelas/(:any)'] = 'GuruKelas/edit_kelas_siswa/$1';
$route['simpan-edit-guru-kelas'] = 'GuruKelas/update_kelas_siswa';


// route siswa
$route['siswa'] = 'siswa/dashboard';
// guru
$route['guru'] = 'siswa/dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
