<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('image')->nullable();
            $table->string('category', 100); // moba, battle-royale, mmorpg, fps, sports, others
            $table->string('publisher', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('category');
            $table->index('is_active');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};