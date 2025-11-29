<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactMessagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('contact_messages')->insert([
            [
                'id' => 1,
                'name' => 'Сәрсенбекұлы Нұрлыбек',
                'email' => 'zzzzzzzhhhhhhh693@gmail.com',
                'phone' => '87773664332',
                'subject' => 'ноутбук',
                'message' => 'Ноутбуктер тым қымбат',
                'status' => 'new',
                'created_at' => '2025-11-18 20:07:53',
            ],
        ]);
    }
}