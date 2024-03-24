<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\MitraModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserMitraController extends BaseController
{
    public function index()
    {
        helper(['form']);
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->get_mitra_by_user_id(session()->get('id'));
        // dd($mitra[0]->id);
        if (!$mitra) {
            return redirect()->to(base_url('mitra/request'));
        }
        $addressModel = new AddressModel();
        $addresses = $addressModel->where('mitra_id', $mitra[0]->id)->findAll();
        $data = [
            'validation' => \Config\Services::validation(),
            'addresses' => $addresses,
            'mitras' => $mitra,
            'title' => 'Mitra'
        ];

        return view('user/mitra/index', $data);
    }
    public function request()
    {
        helper(['form']);
        $data = [
            'validation' => \Config\Services::validation(),
            'title' => 'Request Mitra'
        ];

        return view('user/mitra/request', $data);
    }
    public function store()
    {
        helper(['form']);

        if (!$this->validate('mitra')) {
            $data = [
                'title' => 'Request Mitra',
                'validation' => $this->validator
            ];

            return view('user/mitra/request', $data);
        }

        $mitra = new \App\Entities\MitraEntity();

        $validateData = $this->validator->getValidated();

        $userModel = new UserModel();
        $user = $userModel->where('email', $validateData['email'])->first();

        $mitra->name = $validateData['name'];
        $mitra->user_id = $user->id;
        $mitra->pic_name = $validateData['pic_name'];
        $mitra->pic_contact = $validateData['pic_contact'];

        $mitraModel = new MitraModel();
        $mitraModel->save($mitra);

        $mitra_id = $mitraModel->insertID();

        $data = [
            'name' =>  $validateData['address'],
            'mitra_id' => $mitra_id,
            'main_address' => 1
        ];

        $addressModel = new AddressModel();
        $addressModel->save($data);

        return redirect()->to(base_url('mitra'))->with('success_message', 'Berhasil mengajukan permintaan menjadi mitra');
    }

    public function edit($id)
    {
        helper(['form']);
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where("id", $id)->first();

        $addressModel = new AddressModel();
        $address = $addressModel->where('mitra_id', $mitra->id)->first();

        $data = [
            'validation' => \Config\Services::validation(),
            'mitra' => $mitra,
            'address' => $address,
            'title' => 'Edit Mitra'
        ];

        return view('user/mitra/edit', $data);
    }

    public function add_address($mitra_id)
    {
        $address = $this->request->getPost('address');
        $peminjaman_rules = [
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ]
            ],
        ];

        if (!$this->validate($peminjaman_rules)) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => 'Alamat harus diisi'
            ]);
        }

        $data = [
            'name' => $address,
            'mitra_id' => $mitra_id,
            'main_address' => 0
        ];

        $addressModel = new AddressModel();
        $addressModel->save($data);
    }

    public function update()
    {
        helper(['form']);

        if (!$this->validate('mitra')) {
            $mitraModel = new MitraModel();
            $mitra = $mitraModel->where("id", session()->get('id'))->first();
            $data = [
                'title' => 'Edit Mitra',
                'mitra' => $mitra,
                'validation' => $this->validator
            ];

            return view('user/mitra/edit', $data);
        }
        $mitra = new \App\Entities\MitraEntity();

        $validateData = $this->validator->getValidated();
        $mitra->name = $validateData['name'];
        $mitra->user_id = session()->get('id');
        $mitra->pic_name = $validateData['pic_name'];
        $mitra->pic_contact = $validateData['pic_contact'];
        // dd($mitra);

        $mitraModel = new MitraModel();
        $mitraModel->update($this->request->getPost('mitra_id'), $mitra);

        $data = [
            'name' => $validateData['address'],
        ];

        $addressModel = new AddressModel();
        $addressModel->update($this->request->getPost('address_id'), $data);

        return redirect()->to(base_url('mitra'))->with('success_message', 'Berhasil mengubah pengajuan menjadi mitra');
    }

    public function delete($id)
    {
        $mitraModel = new MitraModel();
        $mitraModel->where('id', $id)->delete();
        return redirect()->to(base_url('mitra'))->with('success_message', 'Berhasil menghapus pengajuan menjadi mitra');
    }
}
