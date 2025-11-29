<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image')->nullable();
            $table->integer('stock')->default(0);
            $table->json('specifications')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['category_id']);
            $table->index(['price']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};