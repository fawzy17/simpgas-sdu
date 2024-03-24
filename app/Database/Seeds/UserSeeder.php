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
                'username' => 'user3',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'user3@gmail.com',
                'role_id' => 3,
            ],
            [
                'id' => 4,
                'username' => 'user4',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'user4@gmail.com',
                'role_id' => 3,
            ],
            [
                'id' => 5,
                'username' => 'user5',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'user5@gmail.com',
                'role_id' => 3,
            ],
            [
                'id' => 6,
                'username' => 'user6',
                'password' => password_hash(12345678, PASSWORD_DEFAULT),
                'email' => 'user6@gmail.com',
                'role_id' => 3,
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}
