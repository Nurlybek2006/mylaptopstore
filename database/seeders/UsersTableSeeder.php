<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'first_name' => 'Админ',
                'last_name' => 'Админов',
                'username' => 'admin',
                'email' => 'admin@laptop.kz',
                'phone' => '+7 777 777 77 77',
                'password' => Hash::make('password'),
                'avatar' => '15.jpg',
                'role' => 'admin',
                'email_verified' => 0,
                'created_at' => '2025-11-16 13:42:06',
                'updated_at' => '2025-11-20 13:43:47',
            ],
            [
                'id' => 2,
                'first_name' => 'Болат',
                'last_name' => 'Болатов',
                'username' => 'bolat',
                'email' => 'bolat@example.com',
                'phone' => '+7 701 234 5678',
                'password' => Hash::make('password'),
                'avatar' => 'default-avatar.jpg',
                'role' => 'user',
                'email_verified' => 0,
                'created_at' => '2025-11-16 13:42:06',
                'updated_at' => '2025-11-16 13:42:06',
            ],
            [
                'id' => 3,
                'first_name' => 'Айгүл',
                'last_name' => 'Айгүлова',
                'username' => 'aigul',
                'email' => 'aigul@example.com',
                'phone' => '+7 702 345 6789',
                'password' => Hash::make('password'),
                'avatar' => 'default-avatar.jpg',
                'role' => 'user',
                'email_verified' => 0,
                'created_at' => '2025-11-16 13:42:06',
                'updated_at' => '2025-11-16 13:42:06',
            ],
            [
                'id' => 4,
                'first_name' => 'Nurlybek',
                'last_name' => 'Sarsenbekuly',
                'username' => 'Nurlybek',
                'email' => 'zzzzzzzhhhhhhh1@gmail.com',
                'phone' => '87773664332',
                'password' => Hash::make('password'),
                'avatar' => '2.jpg',
                'role' => 'user',
                'email_verified' => 0,
                'created_at' => '2025-11-16 13:44:47',
                'updated_at' => '2025-11-18 17:39:06',
            ],
            [
                'id' => 5,
                'first_name' => 'Janbolat',
                'last_name' => 'Toktamuratt',
                'username' => 'Janbo',
                'email' => 'Janbo@gmail.com',
                'phone' => '+7 702 626 9369',
                'password' => Hash::make('password'),
                'avatar' => '16.jpg',
                'role' => 'user',
                'email_verified' => 0,
                'created_at' => '2025-11-17 09:13:10',
                'updated_at' => '2025-11-19 11:46:42',
            ],
            // ... қалған userлерді осылай қосу (6-12 дейін)
        ]);
    }
}