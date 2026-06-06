<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Kyle Smith',
                'email' => 'kyle@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Lily Johnson',
                'email' => 'lily@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Phenix Lee',
                'email' => 'phenix@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Vivian Chen',
                'email' => 'vivian@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'William Brown',
                'email' => 'william@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Marcus Davis',
                'email' => 'marcus@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Michael Scott',
                'email' => 'michael@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}