<?php

use Awcodes\Curator\Models\Media;
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
        Schema::create('mediables', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable');
            $table->foreignIdFor(Media::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->unique(['media_id',  'mediable_id', 'mediable_type'], 'mediables_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediables');
    }
};
