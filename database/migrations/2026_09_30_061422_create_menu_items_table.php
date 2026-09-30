<?php

use App\Models\Settings\Menu;
use App\Models\Settings\MenuItem;
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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Menu::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(MenuItem::class, 'parent_id')->nullable()->constrained()->cascadeOnDelete();
            $table->json('label');
            $table->string('url', 500);
            $table->unsignedInteger('sort_order')->default(0);

            $table->index(['menu_id', 'sort_order']);
            $table->index(['parent_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
