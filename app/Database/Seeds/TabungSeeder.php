<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TabungSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Nitrogen',
                'category_id' => 1,
                'stock' => 100
            ],
            [
                'id' => 2,
                'name' => 'Nitrogen',
                'category_id' => 2,
                'stock' => 100
            ],
            [
                'id' => 3,
                'name' => 'Oksigen',
                'category_id' => 1,
                'stock' => 100
            ],
            [
                'id' => 4,
                'name' => 'Oksigen',
                'category_id' => 2,
                'stock' => 100
            ],
            [
                'id' => 5,
                'name' => 'CO2',
                'category_id' => 4,
                'stock' => 100
            ],
            [
                'id' => 6,
                'name' => 'CO2',
                'category_id' => 5,
                'stock' => 100
            ],
            [
                'id' => 7,
                'name' => 'ARMIX',
                'category_id' => 2,
                'stock' => 100
            ],
            [
                'id' => 8,
                'name' => 'LPG',
                'category_id' => 3,
                'stock' => 100
            ],
            [
                'id' => 9,
                'name' => 'LPG',
                'category_id' => 6,
                'stock' => 100
            ],
            [
                'id' => 10,
                'name' => 'ARGON',
                'category_id' => 1,
                'stock' => 100
            ],
            [
                'id' => 11,
                'name' => 'ARGON',
                'category_id' => 2,
                'stock' => 100
            ],
            [
                'id' => 12,
                'name' => 'ACETYLENE',
                'category_id' => 2,
                'stock' => 100
            ],
        ];

        $this->db->table('tabungs')->insertBatch($data);
    }
}
