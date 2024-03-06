<?php

use App\Controllers\Admin\AdminDashboardController;
use App\Controllers\Admin\AdminMitraController;
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
                $routes->get('/', [AdminTabungController::class, 'list']);
                $routes->get('stok', [AdminTabungController::class, 'stok']);
                $routes->get('request', [AdminTabungController::class, 'request']);
                $routes->get('new', [AdminTabungController::class, 'new']);
                $routes->post('new', [AdminTabungController::class, 'store']);
            });
            $routes->group('mitra', function($routes){
                $routes->get('/', [AdminMitraController::class, 'list']);
                $routes->get('list', [AdminMitraController::class, 'list']);
                $routes->get('request', [AdminMitraController::class, 'request']);
                $routes->get('new', [AdminMitraController::class, 'new']);
                $routes->post('store', [AdminMitraController::class, 'store']);
                $routes->get('edit/(:num)', [AdminMitraController::class, 'edit']);
                $routes->post('update/(:num)', [AdminMitraController::class, 'update']);
                $routes->post('approve', [AdminMitraController::class, 'approve']);
                $routes->post('reject', [AdminMitraController::class, 'reject']);
                $routes->post('revert', [AdminMitraController::class, 'revert']);
            });
        });
    }
);
