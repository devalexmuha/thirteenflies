<?php

use App\Models\Filters\Attribute;
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
        Schema::create('attributables', function (Blueprint $table) {
            $table->id();
            $table->morphs('attributable', 'attributable_morph_index');
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();

            $table->unique(['attribute_id', 'attributable_type', 'attributable_id'], 'attributables_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributables');
    }
};
