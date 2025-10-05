<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('original_price', 12, 2);
            $table->decimal('discounted_price', 12, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->integer('stock');
            $table->integer('sold')->default(0);

            // Ubah dari timestamp() menjadi dateTime()
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};