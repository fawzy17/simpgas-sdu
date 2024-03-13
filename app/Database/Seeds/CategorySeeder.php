<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => '1',
                'massa' => 'kubik',
            ],
            [
                'id' => 2,
                'name' => '6',
                'massa' => 'kubik',
            ],
            [
                'id' => 3,
                'name' => '12',
                'massa' => 'kilogram',
            ],
            [
                'id' => 4,
                'name' => '20',
                'massa' => 'kilogram',
            ],
            [
                'id' => 5,
                'name' => '25',
                'massa' => 'kilogram',
            ],
            [
                'id' => 6,
                'name' => '50',
                'massa' => 'kilogram',
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
