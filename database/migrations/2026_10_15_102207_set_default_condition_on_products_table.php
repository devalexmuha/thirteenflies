<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')->whereNull('condition')->update(['condition' => 'new']);

        Schema::table('products', function (Blueprint $table) {
            $table->string('condition', 20)->default('new')->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('condition', 20)->nullable()->default(null)->change();
        });
    }
};
