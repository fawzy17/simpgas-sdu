<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\PeminjamanModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPeminjamanContoller extends BaseController
{
    public function list_peminjaman()
    {
        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_all_peminjaman_by_mitra();
        // dd($peminjaman);

        $tabungModel = new TabungModel();
        $tabung = $tabungModel->findAll();

        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where('verified', 1)->findAll();
        $data = [
            'peminjamans' => $peminjaman,
            'tabungs' => $tabung,
            'mitras' => $mitra,
            'title' => 'Peminjaman'
        ];

        return view('admin/peminjaman/list', $data);
    }
}
