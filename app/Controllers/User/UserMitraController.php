<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
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
        // dd($mitra);
        if (!$mitra) {
            return redirect()->to(base_url('mitra/request'));
        }
        $data = [
            
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
        $mitra->address = $validateData['address'];
        $mitra->user_id = $user->id;
        $mitra->pic_name = $validateData['pic_name'];
        $mitra->pic_contact = $validateData['pic_contact'];

        $mitraModel = new MitraModel();
        $mitraModel->save($mitra);

        $mitraModel = new MitraModel();
        $mitra = $mitraModel->get_mitra_by_user_id(session()->get('id'));

        $data = [
            
            'mitras' => $mitra,
            'title' => 'Mitra'
        ];

        return redirect()->to(base_url('mitra'))->with('success_message', 'Berhasil mengajukan permintaan menjadi mitra');
    }
}
