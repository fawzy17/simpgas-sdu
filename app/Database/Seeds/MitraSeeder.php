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
                'verified' => 1,
                'pic_name' => 'Rianto',
                'pic_contact' => '089699754015',
            ],
            [
                'id' => 2,
                'name' => 'PT. Hedera',
                'address' => 'JL. Jendral Sudirman',
                'user_id' => 3,
                'verified' => 1,
                'pic_name' => 'Rahma',
                'pic_contact' => 'rahma@gmail.com',
            ],
            [
                'id' => 3,
                'name' => 'PT. Blackrock',
                'address' => 'JL. Jendral Ahmad Yani',
                'user_id' => 3,
                'verified' => 0,
                'pic_name' => 'Leona',
                'pic_contact' => '@leona.br',
            ],
            [
                'id' => 4,
                'name' => 'PT. Tesla',
                'address' => 'JL. Kuningan',
                'user_id' => 3,
                'verified' => NULL,
                'pic_name' => 'Tantan',
                'pic_contact' => '089451347534',
            ],
        ];

        $this->db->table('mitras')->insertBatch($data);
    }
}
