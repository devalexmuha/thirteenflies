<?php

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->string('sku', 64)->unique();
            $table->json('slug')->unique();
            $table->json('name');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->unsignedInteger('price');                        // cents
            $table->unsignedInteger('sale_price')->nullable();       // cents
            $table->timestamp('sale_starts_at')->nullable();
            $table->timestamp('sale_ends_at')->nullable();
            $table->string('condition', 20)->default('new');         // ProductCondition
            $table->unsignedInteger('stock_qty')->default(0);
            $table->boolean('in_stock')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);          // home page
            $table->unsignedTinyInteger('avr_rating');
            $table->timestamps();

            $table->index('price');
            $table->index('sale_price');
            $table->index('condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
