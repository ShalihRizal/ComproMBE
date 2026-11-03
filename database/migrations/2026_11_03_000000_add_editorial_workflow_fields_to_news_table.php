<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'status')) {
                $table->string('status', 20)->default('published')->after('is_headline');
            }
            if (!Schema::hasColumn('news', 'category')) {
                $table->string('category', 100)->nullable()->after('status');
            }
            if (!Schema::hasColumn('news', 'secondary_keywords')) {
                $table->text('secondary_keywords')->nullable()->after('focus_keyword');
            }
        });

        // Modify published_at to DATETIME on MySQL safely without requiring doctrine/dbal
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `news` MODIFY `published_at` DATETIME NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'secondary_keywords')) {
                $table->dropColumn('secondary_keywords');
            }
            if (Schema::hasColumn('news', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('news', 'status')) {
                $table->dropColumn('status');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `news` MODIFY `published_at` DATE NOT NULL');
        }
    }
};
