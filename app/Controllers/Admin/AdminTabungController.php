<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminTabungController extends BaseController
{
    public function index()
    {
        $tabungModel = new TabungModel();
        $tabung = $tabungModel->findAll();
        $data = [
            'tabungs' => $tabung,
            'title' => 'Tabung'
        ];

        return view('admin/tabung/index', $data);
    }

    public function new()
    {
        helper(['form']);

        $data = [
            'title' => 'Tambah Tabung',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/tabung/new', $data);
    }

    public function store()
    {
        helper((['form']));

        if (!$this->validate('tabung')) {
            $data = [
                'title' => 'Tambah Tabung',
                'validation' => $this->validator
            ];

            return view('admin/tabung/new', $data);
        }

        $tabung = new \App\Entities\TabungEntity();
        
        $validateData = $this->validator->getValidated();

        $tabung->name = $validateData['name'];
        $tabung->category = $validateData['category'];
        $tabung->size = $validateData['size'];
        $tabung->weight = $validateData['weight'];

        $tabungModel = new TabungModel();
        $tabungModel->save($tabung);

        return redirect()->to(base_url('admin/tabung'))->with('success_message', 'Berhasil menambahkan data tabung');
    }
}
