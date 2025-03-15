<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buy_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buy_id')->constrained('buys');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('price_product', 10, 2);
            $table->integer('amount');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buy_product');
    }
};
