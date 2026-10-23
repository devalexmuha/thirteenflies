<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use Database\Factories\Data\Catalog\CategoryNames;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * One category per name in CategoryNames; the factory fills its SEO meta (afterCreating).
     */
    public function run(): void
    {
        foreach (CategoryNames::get() as $name) {
            Category::factory()->create(['name' => $name]);
        }
    }
}
