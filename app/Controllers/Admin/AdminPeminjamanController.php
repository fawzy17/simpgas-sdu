<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\PeminjamanModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPeminjamanController extends BaseController
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

    public function list_request_peminjaman(){
        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_peminjaman();
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

        return view('admin/peminjaman/request', $data);
    }

    public function delete($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $deletedRows = $peminjamanModel->where('id', $id)->delete();
        // var_dump($deletedRows);

        if ($deletedRows) {
            $data = [
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data peminjaman',
                'id' => $id
            ];
        } else {
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Gagal menghapus data peminjaman',
                'id' => $id
            ];
        }

        echo json_encode($data);
    }

    public function approve()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = [
            'id' => $id_peminjaman,
            'approval' => 'approved',
            'status' => 'waiting'
        ];

        $peminjamanModel->save($peminjaman);

        echo json_encode($peminjaman);
    }
    public function reject()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = [
            'id' => $id_peminjaman,
            'approval' => 'rejected',
            'status' => NULL
        ];

        $peminjamanModel->save($peminjaman);

        echo json_encode($peminjaman);
    }
    public function revert()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = [
            'id' => $id_peminjaman,
            'approval' => NULL,
            'status' => NULL
        ];

        $peminjamanModel->save($peminjaman);

        echo json_encode($peminjaman);
    }
}
