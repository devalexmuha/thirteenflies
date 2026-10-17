<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('mediables', 'image_type')) {
            Schema::table('mediables', function (Blueprint $table) {
                $table->string('image_type', 30)->nullable()->after('locale');
            });
        }

        Schema::table('mediables', function (Blueprint $table) {
            // 1. New index first (keeps media_id covered for the foreign key)
            $table->unique(
                ['media_id', 'mediable_id', 'mediable_type', 'locale', 'image_type'],
                'mediables_media_locale_type_unique'
            );
            // 2. Then drop the old 3-column one
            $table->dropUnique('mediables_unique');
        });
    }

    public function down(): void
    {
        Schema::table('mediables', function (Blueprint $table) {
            $table->unique(['media_id', 'mediable_id', 'mediable_type'], 'mediables_unique');
            $table->dropUnique('mediables_media_locale_type_unique');
            $table->dropColumn('image_type');
        });
    }
};
