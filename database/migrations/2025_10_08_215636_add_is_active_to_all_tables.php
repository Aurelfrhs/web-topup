<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = ['games', 'banners', 'flash_sales', 'news', 'products'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'is_active')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('id');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['games', 'banners', 'flash_sales', 'news', 'products'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'is_active')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('is_active');
                });
            }
        }
    }
};
