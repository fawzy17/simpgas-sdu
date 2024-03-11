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
                'address' => 'JL. Jendral Ahmad Yani',
                'user_id' => 3,
                'verified' => 1
            ],
            [
                'id' => 2,
                'name' => 'PT. Hedera',
                'address' => 'JL. Jendral Sudirman',
                'user_id' => 3,
                'verified' => 1
            ],
            [
                'id' => 3,
                'name' => 'PT. Blackrock',
                'address' => 'JL. Jendral Ahmad Yani',
                'user_id' => 3,
                'verified' => 0
            ],
            [
                'id' => 4,
                'name' => 'PT. Tesla',
                'address' => 'JL. Kuningan',
                'user_id' => 3,
                'verified' => NULL
            ],
        ];

        $this->db->table('mitras')->insertBatch($data);
    }
}
