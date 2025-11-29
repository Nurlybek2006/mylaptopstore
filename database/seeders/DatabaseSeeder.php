<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            ContactMessagesTableSeeder::class,
            LaptopRequestsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
        ]);
    }
}