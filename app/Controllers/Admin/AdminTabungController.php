<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\TabungModel;
use App\Validation\TabungValidation;
use CodeIgniter\HTTP\ResponseInterface;

class AdminTabungController extends BaseController
{
    public function stock()
    {
        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_detail_tabung();
        // dd($tabung);
        $data = [
            'tabungs' => $tabung,
            'title' => 'Tabung'
        ];

        return view('admin/tabung/stock', $data);
    }

    public function new()
    {
        helper(['form']);

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $data = [
            'title' => 'Tambah Tabung',
            'categories' => $categories,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/tabung/new', $data);
    }

    public function store()
    {
        helper((['form']));


        if (!$this->validate('tabung')) {
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->findAll();
            $data = [
                'title' => 'Tambah Tabung',
                'categories' => $categories,
                'validation' => $this->validator
            ];

            return view('admin/tabung/new', $data);
        }

        $tabung = new \App\Entities\TabungEntity();

        $validateData = $this->validator->getValidated();

        $tabung->name = $validateData['name'];
        $tabung->category = $validateData['category'];
        $tabung->stock = $validateData['stock'];

        $tabungModel = new TabungModel();
        $tabungModel->save($tabung);

        return redirect()->to(base_url('admin/tabung/stock'))->with('success_message', 'Berhasil menambahkan data tabung');
    }

    public function edit(int $id)
    {
        helper(['form']);

        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_tabung_by_id($id);
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $data = [
            'title' => 'Edit Tabung',
            'tabung' => $tabung[0],
            'categories' => $categories,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/tabung/edit', $data);
    }
    public function update(int $id)
    {
        helper(['form']);

        if ($this->request->getPost('stock') < $this->request->getPost('total_borrowed')) {
            $validation = \Config\Services::validation();
            $validation->setError('stock', 'Stock harus lebih dari total tabung yang sedang dipinjam.');
        }

        if (!$this->validate('tabung')) {
            $tabungModel = new TabungModel();
            $tabung = $tabungModel->get_tabung_by_id($id);
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->findAll();
            $data = [
                'title' => 'Edit Tabung',
                'tabung' => $tabung[0],
                'categories' => $categories,
                'validation' => \Config\Services::validation(),
            ];
            return view('admin/tabung/edit', $data);
        }

        $tabung = new \App\Entities\TabungEntity();

        // Use $this->request->getPost() to retrieve form data
        $validateData = $this->request->getPost();

        $tabung->id = $id;
        $tabung->name = $validateData['name'];
        $tabung->category = $validateData['category'];
        $tabung->stock = $validateData['stock'];

        $tabungModel = new TabungModel();
        $tabungModel->save($tabung);

        return redirect()->to(base_url('admin/tabung/stock'))->with('success_message', 'Berhasil mengubah data mitra');
    }


    public function delete($id)
    {
        $tabungModel = new TabungModel();
        $deletedRows = $tabungModel->where('id', $id)->delete();
        // var_dump($deletedRows);

        if ($deletedRows) {
            $data = [
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data',
                'id' => $id
            ];
        } else {
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Gagal menghapus data',
                'id' => $id
            ];
        }

        echo json_encode($data);
    }
}
