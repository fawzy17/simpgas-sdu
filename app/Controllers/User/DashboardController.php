<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/login'));
        };

        $data = [
            'title' => 'Dashboard'
        ];

        return view('user/dashboard', $data);
    }
}
