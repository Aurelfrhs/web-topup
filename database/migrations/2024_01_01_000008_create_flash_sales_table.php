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

            $table->decimal('original_price', 15, 2);
            $table->decimal('discounted_price', 15, 2);
            $table->unsignedTinyInteger('discount_percentage');

            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
