<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\MitraModel;
use App\Models\PeminjamanModel;
use App\Models\TabungModel;
use CodeIgniter\HTTP\ResponseInterface;
use PSpell\Config;

class UserPeminjamanController extends BaseController
{
    public function history()
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->get_mitra_by_user_id(session()->get('id'));
        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_tabung();


        // dd($mitra[0]->id);
        if ($mitra == null) {
            $data = [
                'peminjamans' => [],
                'loan_codes' => [],
                'tabungs' => $tabung,
                'title' => 'Peminjaman'
            ];

            return view('user/peminjaman/history', $data);
        }

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_all_peminjaman_history($mitra[0]->id);
        $loan_codes = $peminjamanModel->get_all_peminjaman_history_by_loan_code($mitra[0]->id);
        // dd($peminjaman);

        $data = [
            'peminjamans' => $peminjaman,
            'loan_codes' => $loan_codes,
            'tabungs' => $tabung,
            'title' => 'Peminjaman'
        ];

        return view('user/peminjaman/history', $data);
    }

    public function request()
    {
        helper(['form']);

        $tabungModel = new TabungModel();
        $tabungs = $tabungModel->get_stock_tabung_ready();

        $mitraModel = new MitraModel();
        $mitra = $mitraModel->get_mitra_by_user_id(session()->get('id'));

        if (!$mitra) {
            $data = [
                'tabungs' => $tabungs,
                'mitra' => [],
                'addresses' => [],
                'validation' => \Config\Services::validation(),
                'title' => 'Peminjaman'
            ];

            return view('user/peminjaman/request', $data);
        }

        $addressModel = new AddressModel();
        $addresses = $addressModel->where('mitra_id', $mitra[0]->id)->findAll();

        $data = [
            'tabungs' => $tabungs,
            'mitra' => $mitra,
            'addresses' => $addresses,
            'validation' => \Config\Services::validation(),
            'title' => 'Peminjaman'
        ];
        // dd($data['mitra'] == null);

        return view('user/peminjaman/request', $data);
    }

    public function store()
    {
        helper((['form']));
        $tabungModel = new TabungModel();
        $tabungs = $tabungModel->get_stock_tabung_ready();
        $peminjaman_rules = [];

        foreach ($tabungs as $tabung) {
            $peminjaman_rules += [
                $tabung->name . $tabung->id => [
                    'rules' => 'required|numeric|less_than_equal_to[' . $tabung->stock_ready . ']',
                    'errors' => [
                        'required' => 'Jumlah tabung tidak boleh kosong',
                        'numeric' => 'Jumlah tabung harus berupa angka',
                        'less_than_equal_to' => 'Tidak dapat meminjam tabung lebih dari stok yang tersedia (' . $tabung->stock_ready . ')'
                    ]
                ]
            ];
        }
        // dd($peminjaman_rules);

        if (!$this->validate($peminjaman_rules)) {
            $tabungModel = new TabungModel();
            $tabung = $tabungModel->get_stock_tabung_ready();
            $mitraModel = new MitraModel();
            $mitra = $mitraModel->findAll();
            $addressModel = new AddressModel();
            $addresses = $addressModel->where('mitra_id', $mitra[0]->id)->findAll();
            $data = [
                'title' => 'Tambah Peminjaman',
                'tabungs' => $tabung,
                'mitra' => $mitra,
                'addresses' => $addresses,
                'validation' => $this->validator
            ];

            return view('user/peminjaman/request', $data);
        }


        $validateData = $this->validator->getValidated();
        // dd($validateData);
        $uniqueCode = substr(uniqid(), -4);

        $currentDate = date('Ymd');

        $loan_code = $currentDate . $uniqueCode;


        foreach ($tabungs as $tabung) {
            if ($validateData[$tabung->name . $tabung->id] > 0) {
                $peminjaman = new \App\Entities\PeminjamanEntity();
                $peminjaman->loan_code = $loan_code;
                $peminjaman->mitra_id = $this->request->getPost('mitra_id');
                $peminjaman->address_id =  $this->request->getPost('address');
                $peminjaman->tabung_id = $tabung->id;
                $peminjaman->amount = $validateData[$tabung->name . $tabung->id];
                // dd($peminjaman);

                $peminjamanModel = new PeminjamanModel();
                $peminjamanModel->save($peminjaman);
            }
        }

        return redirect()->to(base_url('peminjaman/history'))->with('success_message', 'Berhasil menambahkan data peminjaman');
    }
}
