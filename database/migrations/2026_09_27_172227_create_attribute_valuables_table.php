<?php

use App\Models\AttributeValue;
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
            $table->foreignIdFor(AttributeValue::class)->constrained()->cascadeOnDelete();
            $table->morphs('attribute_valuable');
            $table->unique(['attribute_value_id', 'attribute_valuable_type', 'attribute_valuable_id']);
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
