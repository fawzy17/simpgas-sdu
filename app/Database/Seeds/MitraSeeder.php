<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'PT. IndoTera',
                'tubes_borrowed' => 0,
                'address' => 'JL. Jendral Ahmad Yani',
                'user_id' => 3,
                'verified' => 1
            ],
            [
                'id' => 2,
                'name' => 'PT. Hedera',
                'tubes_borrowed' => 0,
                'address' => 'JL. Jendral Sudirman',
                'user_id' => 3,
                'verified' => NULL
            ],
        ];

        $this->db->table('mitras')->insertBatch($data);
    }
}
