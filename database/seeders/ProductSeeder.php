<?php

namespace Database\Seeders;

use App\Models\Catalog\Product;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Products from the factory, with short description and description built from CatalogSentences in every locale.
     */
    public function run(): void
    {
        Product::factory()->count(20)->create()->each(function (Product $product): void {
            $name = $product->getTranslations('name');

            $product->update([
                'short_description' => TextBuilder::forLocales(CatalogSentences::get(), $name, 150, 300),
                'description' => TextBuilder::forLocales(CatalogSentences::get(), $name, 500, 1000),
            ]);
        });
    }
}
