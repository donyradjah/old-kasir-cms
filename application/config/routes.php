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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["login"]["GET"] = "Welcome/login";
$route["login"]["POST"] = "Welcome/submitLogin";
$route["logout"] = "Welcome/logout";

$route["kategori"] = "KategoriFront/index";
$route["kategori/daftar"] = "KategoriFront/index";
$route["kategori/tambah"] = "KategoriFront/tambah";
$route["kategori/simpan"] = "KategoriFront/simpan";
$route["kategori/ubah/(:num)"] = "KategoriFront/ubah/$1";
$route["kategori/simpan-ubah"] = "KategoriFront/simpanUbah";
$route["kategori/hapus"] = "KategoriFront/hapus";

$route["produk"] = "ProdukFront/index";
$route["produk/daftar"] = "ProdukFront/index";
$route["produk/tambah"] = "ProdukFront/tambah";
$route["produk/simpan"] = "ProdukFront/simpan";
$route["produk/ubah/(:num)"] = "ProdukFront/ubah/$1";
$route["produk/simpan-ubah"] = "ProdukFront/simpanUbah";
$route["produk/hapus"] = "ProdukFront/hapus";

$route["perangkat"] = "PerangkatFront/index";
$route["perangkat/daftar"] = "PerangkatFront/index";
$route["perangkat/ubah/(:num)"] = "PerangkatFront/ubah/$1";
$route["perangkat/simpan-ubah"] = "PerangkatFront/simpanUbah";
$route["perangkat/hapus"] = "PerangkatFront/hapus";
$route["perangkat/ganti-meja"] = "PerangkatFront/pasangMeja";

$route["transaksi"] = "TransaksiFront/index";
$route["transaksi/daftar"] = "TransaksiFront/index";
$route["transaksi/detail/(:num)"] = "TransaksiFront/detail/$1";


$route["user"] = "UserFront/index";
$route["user/daftar"] = "UserFront/index";
$route["user/tambah"] = "UserFront/tambah";
$route["user/simpan"] = "UserFront/simpan";
$route["user/ubah/(:num)"] = "UserFront/ubah/$1";
$route["user/simpan-ubah"] = "UserFront/simpanUbah";
$route["user/hapus"] = "UserFront/hapus";


$api = "v1";

$route["api/kategori"] = "api/{$api}/Api/getAll";
$route["produk/ganti-status"] = "api/{$api}/Api/gantiStatus";
$route["transaksi/beli"] = "api/{$api}/Api/simpanTransaksiBaru";
$route["transaksi/simpan-bayar"] = "api/{$api}/Api/simpanBayar";
$route["transaksi/batal"] = "api/{$api}/Api/transaksiBatal";
$route["transaksi/selesai"] = "api/{$api}/Api/simpanSelesai";
