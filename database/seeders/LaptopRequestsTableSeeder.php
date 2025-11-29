<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaptopRequestsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('laptop_requests')->insert([
            [
                'id' => 1,
                'name' => 'Нұрлыбек',
                'email' => 'nurlybek01@gmail.com',
                'phone' => '87771234578',
                'budget' => 400000.00,
                'purpose' => 'Дизайнға арналған мықты характеристикадағы ноутбук керек.',
                'specifications' => 'пластик болмасн ноут',
                'status' => 'processing',
                'created_at' => '2025-11-18 20:13:58',
                'updated_at' => '2025-11-18 20:15:11',
            ],
            [
                'id' => 2,
                'name' => 'Нұрлыбек',
                'email' => 'zzzzzzzhhhhhhh693@gmail.com',
                'phone' => '87771234578',
                'budget' => 600000.00,
                'purpose' => 'Ойынға арналған четки ноут керек',
                'specifications' => '',
                'status' => 'processing',
                'created_at' => '2025-11-20 10:18:11',
                'updated_at' => '2025-11-20 10:18:28',
            ],
        ]);
    }
}