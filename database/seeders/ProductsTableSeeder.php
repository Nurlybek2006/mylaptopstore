<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'ASUS ROG Strix G15',
                'description' => 'Gaming ноутбук, RTX 3060, 16GB RAM, 512GB SSD, 15.6" дисплей',
                'price' => 650000.00,
                'category_id' => 1,
                'image' => 'Acer_Nitro5.jpg',
                'stock' => 8,
                'specifications' => null,
                'created_by' => 1,
                'created_at' => '2025-11-16 13:42:06',
            ],
            [
                'id' => 2,
                'name' => 'MacBook Air M2',
                'description' => 'Apple ноутбук, M2 чипі, 8GB RAM, 256GB SSD, 13.6" Retina дисплей',
                'price' => 800000.00,
                'category_id' => 2,
                'image' => 'mac.jpg',
                'stock' => 15,
                'specifications' => null,
                'created_by' => 1,
                'created_at' => '2025-11-16 13:42:06',
            ],
            [
                'id' => 3,
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Бизнес ноутбук, Intel Core i7, 16GB RAM, 512GB SSD, 14" дисплей',
                'price' => 550000.00,
                'category_id' => 3,
                'image' => 'thinkpad.jpg',
                'stock' => 8,
                'specifications' => null,
                'created_by' => 1,
                'created_at' => '2025-11-16 13:42:06',
            ],
            [
                'id' => 4,
                'name' => 'HP Pavilion 15',
                'description' => 'Студенттік ноутбук, Intel Core i5, 8GB RAM, 256GB SSD, 15.6" дисплей',
                'price' => 350000.00,
                'category_id' => 4,
                'image' => 'hp-pavilion.jpg',
                'stock' => 20,
                'specifications' => null,
                'created_by' => 1,
                'created_at' => '2025-11-16 13:42:06',
            ],
            // ... барлық продуктілерді осылай қосу (5-37 дейін)
        ]);
    }
}