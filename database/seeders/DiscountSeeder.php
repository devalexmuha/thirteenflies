<?php

namespace Database\Seeders;

use App\Enums\DiscountType;
use App\Models\Catalog\Discount;
use Database\Factories\Data\Names\DiscountNames;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * One discount per DiscountType, named from DiscountNames, with SEO texts and slugs.
     */
    public function run(): void
    {
        foreach (DiscountType::cases() as $type) {
            $localeNames = DiscountNames::get()[$type->value];

            $discount = Discount::factory()->create([
                'type' => $type->value,
                'name' => $localeNames,
            ]);

            $discount->seoMeta()->updateOrCreate([], [
                'h1' => $localeNames,
                'seo_text_top' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 200, 500),
                'seo_text_bottom' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 900, 1500),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $discount->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }
        }
    }
}
