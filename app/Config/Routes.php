<?php

use App\Controllers\Admin\AdminDashboardController;
use App\Controllers\Admin\AdminMitraController;
use App\Controllers\Admin\AdminPeminjamanController;
use App\Controllers\Admin\AdminTabungController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Home;
use App\Controllers\User\UserDashboardController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('/home', [Home::class, 'index']);

$routes->group(
    'auth',
    function ($routes) {
        $routes->get('/', [LoginController::class, 'index']);
        $routes->get('login', [LoginController::class, 'index']);
        $routes->post('login', [LoginController::class, 'login']);
        $routes->get('login/google', [LoginController::class, 'loginGoogle']);
        $routes->get('register', [RegisterController::class, 'index']);
        $routes->post('register', [RegisterController::class, 'index']);
        $routes->get('register/google', [RegisterController::class, 'registerGoogle']);
        $routes->post('store', [RegisterController::class, 'register']);
        $routes->delete('logout', [LoginController::class, 'logout']);
    }
);

$routes->group(
    '/',
    ['filter' => 'AuthFilter'],
    function ($routes) {
        $routes->get('dashboard', [UserDashboardController::class, 'index']);

        $routes->group('admin', function ($routes) {
            $routes->get('dashboard', [AdminDashboardController::class, 'index']);
            $routes->group('tabung', function($routes){
                $routes->get('/', [AdminTabungController::class, 'stock']);
                $routes->get('stock', [AdminTabungController::class, 'stock']);
                $routes->get('new', [AdminTabungController::class, 'new']);
                $routes->post('new', [AdminTabungController::class, 'store']);
                $routes->get('edit/(:num)', [AdminTabungController::class, 'edit']);
                $routes->post('update/(:num)', [AdminTabungController::class, 'update']);
                $routes->delete('delete/(:num)', [AdminTabungController::class, 'delete']);
            });
            $routes->group('mitra', function($routes){
                $routes->get('/', [AdminMitraController::class, 'list_mitra']);
                $routes->get('list-mitra', [AdminMitraController::class, 'list_mitra']);
                $routes->get('request-mitra', [AdminMitraController::class, 'request_mitra']);
                $routes->get('new', [AdminMitraController::class, 'new']);
                $routes->post('store', [AdminMitraController::class, 'store']);
                $routes->get('edit/(:num)', [AdminMitraController::class, 'edit']);
                $routes->post('update/(:num)', [AdminMitraController::class, 'update']);
                $routes->delete('delete/(:num)', [AdminMitraController::class, 'delete']);
                $routes->post('approve', [AdminMitraController::class, 'approve']);
                $routes->post('reject', [AdminMitraController::class, 'reject']);
                $routes->post('delete-from-list', [AdminMitraController::class, 'delete_from_list']);
                $routes->post('revert', [AdminMitraController::class, 'revert']);
            });
            $routes->group('peminjaman', function($routes){
                $routes->get('/ ', [AdminPeminjamanController::class, 'list_peminjaman']);
                $routes->get('list-peminjaman', [AdminPeminjamanController::class, 'list_peminjaman']);
                $routes->get('list-request-peminjaman', [AdminPeminjamanController::class, 'list_request_peminjaman']);
                $routes->get('new', [AdminPeminjamanController::class, 'new']);
                $routes->post('new', [AdminPeminjamanController::class, 'store']);
                $routes->post('approve', [AdminPeminjamanController::class, 'approve']);
                $routes->post('reject', [AdminPeminjamanController::class, 'reject']);
                $routes->post('revert', [AdminPeminjamanController::class, 'revert']);
                $routes->post('change-status', [AdminPeminjamanController::class, 'change_status']);
                $routes->delete('delete/(:num)', [AdminPeminjamanController::class, 'delete']);
            });
        });
    }
);
