<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 255)->nullable();
            $table->string('stripe_payment_id', 255)->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_name', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->integer('quantity')->default(1);
            $table->string('status', 50)->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('customer_email', 255)->nullable();
            $table->string('customer_name', 255)->nullable();
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};