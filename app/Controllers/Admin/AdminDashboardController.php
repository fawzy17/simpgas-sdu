<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\PeminjamanModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $mitraModel = new MitraModel();
        $total_mitras = $mitraModel->get_verified_mitra();

        $tabungModel = new TabungModel();
        $total_stock_tabungs = $tabungModel->get_total_stock();

        $peminjamanModel = new PeminjamanModel();
        $total_borrowed = $peminjamanModel->get_total_borrowed();

        $borrowed_per_month = $peminjamanModel->get_peminjaman_per_month();

        $months = $peminjamanModel->get_month();

        $data = [
            'total_mitras' => $total_mitras,
            'total_stock_tabungs' => $total_stock_tabungs,
            'total_borrowed' => $total_borrowed,
            'borrowed_per_month' => $borrowed_per_month,
            'months' => $months,
            'title' => 'Dashboard'
        ];

        return view('admin/dashboard', $data);
    }
}
