<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_id')->constrained('payments');
            $table->enum('state', ['processing', 'completed', 'failed'])->default('processing');
            $table->decimal('total', 10, 2);
            $table->integer('amount_products');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
