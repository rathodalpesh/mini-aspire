<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy', // password
                'remember_token' => null,
                'role'           => 1,
                'status'         => 1,
            ],
            [
                'name'           => 'Alpesh',
                'email'          => 'alpeshdiu@gmail.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy', // password
                'remember_token' => null,
                'role'           => 0,
                'status'         => 1,
            ],
        ];

        User::insert($users);
    }
}
