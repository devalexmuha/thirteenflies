<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('slugs', 'slugs_old');

        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->morphs('sluggable');
            $table->string('locale', 5);
            $table->string('slug');

            $table->unique(['sluggable_type', 'sluggable_id', 'locale'], 'unique_parent_per_locale');
            $table->unique(['sluggable_type', 'locale', 'slug'], 'unique_slug_per_parent_type_locale');
        });

        DB::table('slugs_old')->orderBy('id')->each(function (object $row): void {
            foreach (json_decode($row->slug, true) ?? [] as $locale => $value) {
                if (blank($value)) {
                    continue;
                }

                DB::table('slugs')->insert([
                    'sluggable_type' => $row->sluggable_type,
                    'sluggable_id' => $row->sluggable_id,
                    'locale' => $locale,
                    'slug' => Str::slug($value, '-', $locale),
                ]);
            }
        });

        Schema::drop('slugs_old');
    }

    public function down(): void
    {
        Schema::rename('slugs', 'slugs_new');

        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->morphs('sluggable');
            $table->json('slug');

            $table->unique(['sluggable_type', 'sluggable_id'], 'unique_slug');
        });

        DB::table('slugs_new')
          ->orderBy('id')
          ->get()
          ->groupBy(fn (object $row) => $row->sluggable_type.'|'.$row->sluggable_id)
          ->each(function ($rows): void {
              DB::table('slugs')->insert([
                  'sluggable_type' => $rows->first()->sluggable_type,
                  'sluggable_id' => $rows->first()->sluggable_id,
                  'slug' => json_encode($rows->pluck('slug', 'locale')),
              ]);
          });

        Schema::drop('slugs_new');
    }
};
