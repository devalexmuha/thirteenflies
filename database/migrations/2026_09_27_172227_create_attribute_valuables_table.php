<?php

use App\Models\Filters\AttributeValue;
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
        Schema::create('attribute_valuables', function (Blueprint $table) {
            $table->id();
            $table->morphs('attribute_valuable', 'attribute_valuables_morph_index');
            $table->foreignIdFor(AttributeValue::class)->constrained()->cascadeOnDelete();
            $table->unique(['attribute_value_id', 'attribute_valuable_type', 'attribute_valuable_id'], 'attribute_valuables_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_valuables');
    }
};
