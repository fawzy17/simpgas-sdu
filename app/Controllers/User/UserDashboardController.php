<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserDashboardController extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Dashboard'
        ];

        return view('user/dashboard', $data);
    }
}
