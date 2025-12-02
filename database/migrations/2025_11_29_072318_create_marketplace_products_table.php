<?php
// 2025_11_29_072318_create_marketplace_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketplace_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category', 100)->nullable();
            $table->string('brand', 100)->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('used');
            $table->text('images')->nullable();
            $table->enum('status', ['active', 'sold', 'inactive'])->default('active');
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes(); // Жұмсақ жою үшін қосу
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_products');
    }
};