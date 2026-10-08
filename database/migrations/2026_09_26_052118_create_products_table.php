<?php

use App\Models\Catalog\Brand;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Promotion;
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
            $table->foreignIdFor(Brand::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Promotion::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Discount::class)->nullable()->constrained()->nullOnDelete();
            $table->string('sku', 64)->unique();
            $table->json('name');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('condition')->nullable();
            $table->boolean('is_discounted')->default(false);
            $table->unsignedInteger('discount_price')->nullable();

            $table->unsignedInteger('stock_qty')->default(0);
            $table->boolean('in_stock')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);          // home page
            $table->unsignedTinyInteger('avr_rating')->default(0);
            $table->timestamps();

            $table->index('price');
            $table->index('discount_price');
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
