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
                'amount' => 10
            ],
            [
                'id' => 2,
                'loan_code' => 'asrcas12',
                'mitra_id' => 1,
                'tabung_id' => 2,
                'amount' => 15
            ],
            [
                'id' => 3,
                'loan_code' => 'asrcas11',
                'mitra_id' => 2,
                'tabung_id' => 2,
                'amount' => 15
            ],
        ];

        $this->db->table('peminjamans')->insertBatch($data);
    }
}
