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
                'status' => NULL,
                'address_id' => 1,
            ],
            [
                'id' => 2,
                'loan_code' => 'asrcas12',
                'mitra_id' => 1,
                'tabung_id' => 2,
                'amount' => 15,
                'approval' => 'approved',
                'status' => 'done',
                'address_id' => 2
            ],
            [
                'id' => 3,
                'loan_code' => 'asrcas11',
                'mitra_id' => 2,
                'tabung_id' => 3,
                'amount' => 15,
                'approval' => 'approved',
                'status' => 'waiting',
                'address_id' => 3
            ],
            [
                'id' => 4,
                'loan_code' => 'asrcas13',
                'mitra_id' => 3,
                'tabung_id' => 9,
                'amount' => 15,
                'approval' => 'rejected',
                'status' => 'waiting',
                'address_id' => 4
            ],
        ];

        $this->db->table('peminjamans')->insertBatch($data);
    }
}
