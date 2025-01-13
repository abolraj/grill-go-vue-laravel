<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('total_number');
            $table->unsignedBigInteger('total_price');
            $table->smallInteger('status');
            $table->integer('duration');
            $table->foreignId('customer_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
