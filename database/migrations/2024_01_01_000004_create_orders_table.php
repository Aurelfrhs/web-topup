<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('order_number', 50)->unique();
            $table->string('user_game_id', 100);
            $table->string('server_id', 100)->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('payment_method', 50);
            $table->enum('payment_status', ['unpaid', 'paid', 'expired'])->default('unpaid');
            $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
