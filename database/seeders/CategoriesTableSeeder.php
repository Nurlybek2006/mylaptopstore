<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Gaming ноутбуктер',
                'description' => 'Ойындарға арналған күшті ноутбуктер',
                'created_at' => '2025-11-16 18:42:06',
            ],
            [
                'id' => 2,
                'name' => 'Ұсытылған ноутбуктер',
                'description' => 'Күнделікті қолдануға арналған',
                'created_at' => '2025-11-16 18:42:06',
            ],
            [
                'id' => 3,
                'name' => 'Бизнес ноутбуктер',
                'description' => 'Жұмыс үшін арналған',
                'created_at' => '2025-11-16 18:42:06',
            ],
            [
                'id' => 4,
                'name' => 'Студенттік ноутбуктер',
                'description' => 'Оқуға арналған',
                'created_at' => '2025-11-16 18:42:06',
            ],
        ]);
    }
}