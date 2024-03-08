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
                'category' => 1,
                'size' => 10000,
                'weight' => 100
            ],
            [
                'id' => 2,
                'name' => 'Oksigen',
                'category' => 1,
                'size' => 10000,
                'weight' => 100
            ],
        ];

        $this->db->table('tabungs')->insertBatch($data);
    }
}
