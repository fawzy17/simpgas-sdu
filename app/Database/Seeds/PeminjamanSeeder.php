<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'loan_code' => 'asrcas12',
                'mitra_id' => 1,
                'tabung_id' => 1,
                'amount' => 10,
                'approval' => NULL,
                'status' => NULL
            ],
            [
                'id' => 2,
                'loan_code' => 'asrcas12',
                'mitra_id' => 1,
                'tabung_id' => 2,
                'amount' => 15,
                'approval' => 'approved',
                'status' => 'done'
            ],
            [
                'id' => 3,
                'loan_code' => 'asrcas11',
                'mitra_id' => 2,
                'tabung_id' => 2,
                'amount' => 15,
                'approval' => 'approved',
                'status' => 'waiting'
            ],
            [
                'id' => 4,
                'loan_code' => 'asrcas13',
                'mitra_id' => 1,
                'tabung_id' => 2,
                'amount' => 15,
                'approval' => 'rejected',
                'status' => 'waiting'
            ],
        ];

        $this->db->table('peminjamans')->insertBatch($data);
    }
}
