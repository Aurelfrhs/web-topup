<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Contoh: Dana, OVO, Bank BCA, QRIS
            $table->string('code', 50)->unique(); // contoh: DANA, OVO, BCA, QRIS
            $table->string('type', 50)->default('ewallet'); // ewallet, bank, qris, manual
            $table->decimal('fee_percent', 5, 2)->default(0);
            $table->decimal('fee_fixed', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('instructions')->nullable(); // instruksi manual transfer jika ada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
