<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'username' => 'superadmin',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'superadmin@gmail.com',
                'role_id' => 1,
            ],
            [
                'id' => 2,
                'username' => 'admin',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'admin@gmail.com',
                'role_id' => 2,
            ],
            [
                'id' => 3,
                'username' => 'user',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'user@gmail.com',
                'role_id' => 3,
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}
