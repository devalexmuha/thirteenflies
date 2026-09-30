<?php

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
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->morphs('seoable');
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('h1')->nullable();
            $table->json('seo_text_top')->nullable();
            $table->json('seo_text_bottom')->nullable();
            $table->json('alt')->nullable();
            $table->string('canonical', 500)->nullable();
            $table->string('robots', 50)->default('index, follow');
            $table->json('schema')->nullable();
            $table->timestamps();

            $table->unique(['seoable_type', 'seoable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
