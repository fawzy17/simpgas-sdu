<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPeminjamanContoller extends BaseController
{
    public function list_peminjaman()
    {
        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_peminjaman();
        $data = [
            'peminjamans' => $peminjaman,
            'title' => 'Peminjaman'
        ];

        return view('admin/peminjaman/list', $data);
    }
}
