<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\TabungModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminMitraController extends BaseController
{
    public function list()
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->get_mitra();
        $data = [
            'mitras' => $mitra,
            'title' => 'Mitra'
        ];

        return view('admin/mitra/list', $data);
    }
    public function request()
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->findAll();
        $data = [
            'mitras' => $mitra,
            'title' => 'Mitra'
        ];

        return view('admin/mitra/request', $data);
    }

    public function new()
    {
        helper(['form']);

        $data = [
            'title' => 'Tambah Mitra',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/mitra/new', $data);
    }

    public function store()
    {
        helper((['form']));

        if (!$this->validate('mitra')) {
            $data = [
                'title' => 'Tambah Mitra',
                'validation' => $this->validator
            ];

            return view('admin/mitra/new', $data);
        }

        $mitra = new \App\Entities\MitraEntity();
        
        $validateData = $this->validator->getValidated();

        $userModel = new UserModel();
        $user = $userModel->where('email', $validateData['email'])->first();

        $mitra->name = $validateData['name'];
        $mitra->tubes_borrowe = $validateData['tubes_borrowed'];
        $mitra->address = $validateData['address'];
        $mitra->user_id = $user->id;

        $mitraModel = new MitraModel();
        $mitraModel->save($mitra);

        return redirect()->to(base_url('admin/mitra/list'))->with('success_message', 'Berhasil menambahkan data mitra');
    }

    public function approve(){
        $id_mitra = $this->request->getPost('id_mitra');

        $mitraModel = new MitraModel();
        $mitra = [
            'id' => $id_mitra,
            'verified' => 1
        ];

        $mitraModel->save($mitra);

        echo json_encode($mitra);
    }
    public function reject(){
        $id_mitra = $this->request->getPost('id_mitra');

        $mitraModel = new MitraModel();
        $mitra = [
            'id' => $id_mitra,
            'verified' => 0
        ];

        $mitraModel->save($mitra);

        echo json_encode($mitra);
    }
}
