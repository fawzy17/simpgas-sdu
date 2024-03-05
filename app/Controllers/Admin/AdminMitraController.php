<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminMitraController extends BaseController
{
    public function index()
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->findAll();
        $data = [
            'mitras' => $mitra,
            'title' => 'Mitra'
        ];

        return view('admin/mitra/index', $data);
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

        $mitra->name = $validateData['name'];
        $mitra->tubes_borrowe = $validateData['tubes_borrowed'];
        $mitra->address = $validateData['address'];

        $mitraModel = new MitraModel();
        $mitraModel->save($mitra);

        return redirect()->to(base_url('admin/mitra'))->with('success_message', 'Berhasil menambahkan data mitra');
    }
}
