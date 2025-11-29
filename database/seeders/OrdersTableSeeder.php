<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $orders = [
            [
                'id' => 1,
                'session_id' => null,
                'stripe_payment_id' => null,
                'product_id' => null,
                'product_name' => null,
                'user_id' => 2,
                'total_amount' => 650000.00,
                'shipping_cost' => 0.00,
                'quantity' => 1,
                'status' => 'completed',
                'payment_method' => null,
                'shipping_address' => 'Алматы к., Абай көш. 123, 45 п.',
                'phone' => '+7 701 234 5678',
                'customer_email' => null,
                'customer_name' => null,
                'created_at' => '2025-11-16 18:42:06',
            ],
            [
                'id' => 2,
                'session_id' => null,
                'stripe_payment_id' => null,
                'product_id' => null,
                'product_name' => null,
                'user_id' => 3,
                'total_amount' => 350000.00,
                'shipping_cost' => 0.00,
                'quantity' => 1,
                'status' => 'completed',
                'payment_method' => null,
                'shipping_address' => 'Астана к., Достык көш. 456, 12 п.',
                'phone' => '+7 702 345 6789',
                'customer_email' => null,
                'customer_name' => null,
                'created_at' => '2025-11-16 18:42:06',
            ],
            [
                'id' => 3,
                'session_id' => null,
                'stripe_payment_id' => null,
                'product_id' => null,
                'product_name' => null,
                'user_id' => 4,
                'total_amount' => 650000.00,
                'shipping_cost' => 0.00,
                'quantity' => 1,
                'status' => 'completed',
                'payment_method' => null,
                'shipping_address' => null,
                'phone' => null,
                'customer_email' => null,
                'customer_name' => null,
                'created_at' => '2025-11-16 20:23:16',
            ],
            [
                'id' => 4,
                'session_id' => null,
                'stripe_payment_id' => null,
                'product_id' => null,
                'product_name' => null,
                'user_id' => 4,
                'total_amount' => 650000.00,
                'shipping_cost' => 0.00,
                'quantity' => 1,
                'status' => 'pending',
                'payment_method' => null,
                'shipping_address' => null,
                'phone' => null,
                'customer_email' => null,
                'customer_name' => null,
                'created_at' => '2025-11-18 20:20:55',
            ],
            [
                'id' => 5,
                'session_id' => null,
                'stripe_payment_id' => null,
                'product_id' => null,
                'product_name' => null,
                'user_id' => 5,
                'total_amount' => 1954989.00,
                'shipping_cost' => 0.00,
                'quantity' => 1,
                'status' => 'pending',
                'payment_method' => null,
                'shipping_address' => null,
                'phone' => null,
                'customer_email' => null,
                'customer_name' => null,
                'created_at' => '2025-11-24 09:49:27',
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}