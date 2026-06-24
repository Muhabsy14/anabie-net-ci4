<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', static fn () => redirect()->to('/login'));

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');
$routes->get('logout', 'AuthController::logout');

$managementRoutes = static function ($routes, string $namespace, string $prefix) {
    $routes->get('dashboard', "{$namespace}\DashboardController::index");

    $routes->get('pelanggan', "{$namespace}\PelangganController::index");
    $routes->post('pelanggan', "{$namespace}\PelangganController::store");
    $routes->post('pelanggan/update/(:num)', "{$namespace}\PelangganController::update/$1");
    $routes->get('pelanggan/delete/(:num)', "{$namespace}\PelangganController::delete/$1");

    $routes->get('profil', "{$namespace}\ProfilController::index");
    $routes->post('profil', "{$namespace}\ProfilController::update");

    $routes->get('paket', "{$namespace}\PaketController::index");
    $routes->post('paket', "{$namespace}\PaketController::store");
    $routes->post('paket/update/(:num)', "{$namespace}\PaketController::update/$1");
    $routes->get('paket/delete/(:num)', "{$namespace}\PaketController::delete/$1");

    $routes->get('tagihan', "{$namespace}\TagihanController::index");
    $routes->post('tagihan', "{$namespace}\TagihanController::store");
    $routes->post('tagihan/update/(:num)', "{$namespace}\TagihanController::update/$1");
    $routes->get('tagihan/delete/(:num)', "{$namespace}\TagihanController::delete/$1");

    $routes->get('pembayaran', "{$namespace}\PembayaranController::index");
    $routes->post('pembayaran', "{$namespace}\PembayaranController::store");

    $routes->get('notifikasi', "{$namespace}\NotifikasiController::index");
    $routes->post('notifikasi/kirim', "{$namespace}\NotifikasiController::kirim");

    $routes->get('pengaduan', "{$namespace}\PengaduanController::index");
    $routes->post('pengaduan/update/(:num)', "{$namespace}\PengaduanController::update/$1");

    $routes->get('laporan', "{$namespace}\LaporanController::index");
    $routes->get('laporan/pdf', "{$namespace}\LaporanController::pdf");
};

$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) use ($managementRoutes) {
    $managementRoutes($routes, 'Admin', 'admin');
});

$routes->group('owner', ['filter' => 'auth:owner'], static function ($routes) use ($managementRoutes) {
    $managementRoutes($routes, 'Owner', 'owner');

    $routes->get('admin', 'Owner\PenggunaController::index');
    $routes->post('admin', 'Owner\PenggunaController::store');
    $routes->post('admin/update/(:num)', 'Owner\PenggunaController::update/$1');
    $routes->get('admin/delete/(:num)', 'Owner\PenggunaController::delete/$1');
});

$routes->group('pelanggan', ['filter' => 'auth:pelanggan'], static function ($routes) {
    $routes->get('dashboard', 'Pelanggan\DashboardController::index');
    $routes->get('profil', 'Pelanggan\ProfilController::index');
    $routes->post('profil', 'Pelanggan\ProfilController::update');
    $routes->get('tagihan', 'Pelanggan\TagihanController::index');
    $routes->get('riwayat', 'Pelanggan\RiwayatController::index');
    $routes->get('pengaduan', 'Pelanggan\PengaduanController::index');
    $routes->post('pengaduan', 'Pelanggan\PengaduanController::store');
});
