<?php

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Home;
use App\Controllers\User\DashboardController;
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

$routes->get('dashboard', [DashboardController::class, 'index']);
