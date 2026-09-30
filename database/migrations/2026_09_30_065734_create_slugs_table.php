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
        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->morphs('sluggable');
            $table->string('locale', 5);
            $table->string('slug');

            $table->unique(['sluggable_type', 'sluggable_id', 'locale'], 'unique_parent_per_locale');
            $table->unique(['sluggable_type', 'locale', 'slug'], 'unique_slug_per_parent_type_locale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slugs');
    }
};
