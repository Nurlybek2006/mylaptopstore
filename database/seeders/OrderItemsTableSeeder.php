<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        // Алдымен бар продукттарды алу
        $products = DB::table('products')->get();
        
        // Егер продукттар жоқ болса, бос қалдыру
        if ($products->isEmpty()) {
            return;
        }

        // Бірінші және соңғы продукттарды алу
        $firstProduct = $products->first();
        $lastProduct = $products->last();

        $orderItems = [
            [
                'id' => 1,
                'order_id' => 2,
                'product_id' => $firstProduct->id, // Бірінші продукт
                'quantity' => 1,
                'price' => $firstProduct->price,
            ],
            [
                'id' => 2,
                'order_id' => 5,
                'product_id' => $lastProduct->id, // Соңғы продукт
                'quantity' => 1,
                'price' => $lastProduct->price,
            ],
        ];

        DB::table('order_items')->insert($orderItems);
    }
}