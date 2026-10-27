<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('promotion_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['product_id', 'promotion_id']);
        });

        DB::table('product_promotion')->insertUsing(
            ['product_id', 'promotion_id', 'created_at', 'updated_at'],
            DB::table('products')
                ->whereNotNull('promotion_id')
                ->select('id', 'promotion_id', DB::raw('CURRENT_TIMESTAMP'), DB::raw('CURRENT_TIMESTAMP'))
        );

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promotion_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('promotion_id')->nullable()->constrained()->nullOnDelete();
        });

        DB::statement('UPDATE products p JOIN product_promotion pp ON pp.product_id = p.id SET p.promotion_id = pp.promotion_id');

        Schema::dropIfExists('product_promotion');
    }
};
