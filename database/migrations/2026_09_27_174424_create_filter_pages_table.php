<?php

use App\Models\Brand;
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
        Schema::create('filter_pages', function (Blueprint $table) {
            $table->id();
            $table->morphs('filterable');
            $table->foreignIdFor(Brand::class)->nullable()->constrained()->nullOnDelete();
            $table->json('name');
            $table->string('seo_path');
            $table->string('filters_key')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['filterable_type', 'filterable_id', 'seo_path'], 'filter_pages_seo_path_unique');
            $table->unique(['filterable_type', 'filterable_id', 'filters_key'], 'filter_pages_filters_key_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_pages');
    }
};
