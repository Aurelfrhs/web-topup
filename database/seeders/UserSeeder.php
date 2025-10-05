<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'erick',
                'email' => 'erick@mail.com',
                'password' => Hash::make('123456'),
                'phone' => '081234567890',
                'balance' => 100000,
                'membership' => 'basic',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin123'),
                'phone' => '081111111111',
                'balance' => 0,
                'membership' => 'platinum',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

