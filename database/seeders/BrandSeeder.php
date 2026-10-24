<?php

namespace Database\Seeders;

use App\Enums\Locale;
use App\Models\Catalog\Brand;
use Database\Factories\Data\AttributeValues\BrandAttributeValues;
use Database\Factories\Data\Names\BrandNames;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\AttributeAssigner;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * One brand per name in BrandNames, with description, SEO texts, slugs and filter attributes.
     */
    public function run(): void
    {
        foreach (BrandNames::get() as $name) {
            $localeNames = array_fill_keys(array_column(Locale::cases(), 'value'), $name);

            $brand = Brand::factory()->create([
                'name' => $name,
            ]);

            $brand->seoMeta()->updateOrCreate([], [
                'h1' => $localeNames,
                'seo_text_top' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 200, 500),
                'seo_text_bottom' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 900, 1500),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $brand->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }

            AttributeAssigner::assign($brand, BrandAttributeValues::get()[$name] ?? []);
        }
    }
}
