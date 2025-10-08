<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Drop old column if exists
            if (Schema::hasColumn('games', 'status')) {
                $table->dropColumn('status');
            }

            // Add new columns if not exists
            if (!Schema::hasColumn('games', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('description');
            }

            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug', 255)->unique()->after('name');
            }

            if (!Schema::hasColumn('games', 'publisher')) {
                $table->string('publisher', 255)->nullable()->after('category');
            }

            if (!Schema::hasColumn('games', 'description')) {
                $table->text('description')->nullable()->after('publisher');
            }

            // Modify existing columns
            $table->string('name', 255)->change();
            $table->string('category', 100)->change();

            // Add indexes
            if (!$this->hasIndex('games', 'games_category_index')) {
                $table->index('category');
            }
            if (!$this->hasIndex('games', 'games_is_active_index')) {
                $table->index('is_active');
            }
            if (!$this->hasIndex('games', 'games_slug_index')) {
                $table->index('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Revert changes
            if (Schema::hasColumn('games', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('games', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('games', 'publisher')) {
                $table->dropColumn('publisher');
            }
            if (Schema::hasColumn('games', 'description')) {
                $table->dropColumn('description');
            }

            // Add back old status column
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Check if index exists
     */
    private function hasIndex($table, $index)
    {
        $indexes = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableIndexes($table);

        return array_key_exists($index, $indexes);
    }
};