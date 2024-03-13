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
        $tabung = $tabungModel->get_tabung();
        // dd($tabung);

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

    public function list_request_peminjaman()
    {
        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->get_peminjaman();
        // dd($peminjaman);

        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_tabung();

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

    public function new()
    {
        helper(['form']);

        $tabungModel = new TabungModel();
        $tabung = $tabungModel->get_stock_tabung_ready();

        $mitraModel = new MitraModel();
        $mitra = $mitraModel->findAll();

        $data = [
            'title' => 'Tambah Peminjaman',
            'tabungs' => $tabung,
            'mitras' => $mitra,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/peminjaman/new', $data);
    }

    public function store()
    {
        helper((['form']));
        $tabungModel = new TabungModel();
        $tabungs = $tabungModel->get_stock_tabung_ready();
        $peminjaman_rules = [
            'mitra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama mitra harus diisi'
                ]
            ],
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ]
            ],
        ];

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
            $data = [
                'title' => 'Tambah Peminjaman',
                'tabungs' => $tabung,
                'mitras' => $mitra,
                'validation' => $this->validator
            ];

            return view('admin/peminjaman/new', $data);
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
                $peminjaman->mitra_id = $validateData['mitra'];
                $peminjaman->tabung_id = $tabung->id;
                $peminjaman->amount = $validateData[$tabung->name . $tabung->id];
                // dd($peminjaman);

                $peminjamanModel = new PeminjamanModel();
                $peminjamanModel->save($peminjaman);
            }
        }

        return redirect()->to(base_url('admin/peminjaman/list-request-peminjaman'))->with('success_message', 'Berhasil menambahkan data peminjaman');
    }

    public function delete($loan_code)
    {
        $peminjamanModel = new PeminjamanModel();
        $deletedRows = $peminjamanModel->where('loan_code', $loan_code)->delete();

        if ($deletedRows) {
            $data = [
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil menghapus data peminjaman',
            ];
        } else {
            $data = [
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Gagal menghapus data peminjaman',
            ];
        }
        // $data = [
        //     'status' => 'error',
        //     'title' => 'Gagal',
        //     'message' => 'Gagal menghapus data peminjaman',
        // ];

        echo json_encode($data);
    }

    public function approve()
    {
        $loan_code = $this->request->getPost('loan_code');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->where('loan_code', $loan_code)->findAll();

        if ($peminjaman) {
            $dataToUpdate = [
                'approval' => 'approved',
                'status' => 'waiting',
            ];

            // Update seluruh data dengan loan_code yang sama
            $peminjamanModel->set($dataToUpdate)->where('loan_code', $loan_code)->update();

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disetujui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function reject()
    {
        $loan_code = $this->request->getPost('loan_code');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->where('loan_code', $loan_code)->findAll();

        if ($peminjaman) {
            $dataToUpdate = [
                'approval' => 'rejected',
                'status' => NULL,
            ];

            $peminjamanModel->set($dataToUpdate)->where('loan_code', $loan_code)->update();

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disetujui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
    public function revert()
    {
        $loan_code = $this->request->getPost('loan_code');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->where('loan_code', $loan_code)->findAll();

        if ($peminjaman) {
            $dataToUpdate = [
                'approval' => NULL,
                'status' => NULL,
            ];

            $peminjamanModel->set($dataToUpdate)->where('loan_code', $loan_code)->update();

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disetujui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function change_status()
    {
        $loan_code = $this->request->getPost('loan_code');
        $selected_status = $this->request->getPost('selected_status');

        $peminjamanModel = new PeminjamanModel();
        $peminjaman = $peminjamanModel->where('loan_code', $loan_code)->findAll();

        if ($peminjaman) {
            $dataToUpdate = [
                'status' => $selected_status,
            ];

            // Update seluruh data dengan loan_code yang sama
            $peminjamanModel->set($dataToUpdate)->where('loan_code', $loan_code)->update();

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disetujui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
}
