<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Order Information
            $table->string('order_number', 50)->unique();
            $table->string('game_user_id', 100);
            $table->string('server_id', 100)->nullable();

            // Pricing
            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 50);

            // Status
            $table->enum('status', ['pending', 'processing', 'success', 'failed', 'refunded'])
                ->default('pending');

            // Additional Information
            $table->text('note')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('user_id');
            $table->index('product_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('game_user_id');
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