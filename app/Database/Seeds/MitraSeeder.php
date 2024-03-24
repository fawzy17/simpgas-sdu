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
                'user_id' => 3,
                'verified' => 1,
                'pic_name' => 'Rianto',
                'pic_contact' => '089699754015',
            ],
            [
                'id' => 2,
                'name' => 'PT. Hedera',
                'user_id' => 4,
                'verified' => 1,
                'pic_name' => 'Rahma',
                'pic_contact' => 'rahma@gmail.com',
            ],
            [
                'id' => 3,
                'name' => 'PT. Blackrock',
                'user_id' => 5,
                'verified' => 0,
                'pic_name' => 'Leona',
                'pic_contact' => '@leona.br',
            ],
            [
                'id' => 4,
                'name' => 'PT. Tesla',
                'user_id' => 6,
                'verified' => NULL,
                'pic_name' => 'Tantan',
                'pic_contact' => '089451347534',
            ],
        ];

        $this->db->table('mitras')->insertBatch($data);
    }
}
