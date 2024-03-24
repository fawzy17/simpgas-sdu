<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'JL. Jendral Ahmad Yani',
                'mitra_id' => 1,
                'main_address' => 1
            ],
            [
                'id' => 2,
                'name' => 'JL. Penaburan',
                'mitra_id' => 1,
                'main_address' => 0
            ],
            [
                'id' => 3,
                'name' => 'JL. Kayangan',
                'mitra_id' => 2,
                'main_address' => 1
            ],
            [
                'id' => 4,
                'name' => 'JL. Deltamas',
                'mitra_id' => 3,
                'main_address' => 1
            ],
            [
                'id' => 5,
                'name' => 'JL. Kalimalang',
                'mitra_id' => 4,
                'main_address' => 1
            ],
        ];

        $this->db->table('addresses')->insertBatch($data);
    }
}
