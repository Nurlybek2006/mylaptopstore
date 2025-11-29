<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laptop_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 20)->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->text('purpose')->nullable();
            $table->text('specifications')->nullable();
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laptop_requests');
    }
};