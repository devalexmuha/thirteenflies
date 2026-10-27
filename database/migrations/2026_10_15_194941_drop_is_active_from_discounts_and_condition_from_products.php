<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['condition']);
            $table->dropColumn('condition');
        });
    }

    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('type');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('condition', 20)->default('new')->after('price');
        });
    }
};
