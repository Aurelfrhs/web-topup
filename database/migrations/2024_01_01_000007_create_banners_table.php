<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // ← Pastikan ada nullable()
            $table->string('link')->nullable();
            $table->enum('position', ['home', 'games', 'flash-sale'])->default('home');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};