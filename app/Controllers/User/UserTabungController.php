<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\PeminjamanModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserTabungController extends BaseController
{
    public function index()
    {
        
        
        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_all_peminjaman_by_mitra();
        // dd($peminjaman);

        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_tabung();
        // dd($tabung);

        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where('user_id', session()->get('id'))->first();
        $data = [
            'peminjamans' => $peminjaman,
            'tabungs' => $tabung,
            'mitra' => $mitra,
            'title' => 'Tabung'
        ];
        return view('user/tabung/index', $data);
    }
}
