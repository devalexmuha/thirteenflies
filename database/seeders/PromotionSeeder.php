<?php

namespace Database\Seeders;

use App\Models\Catalog\Promotion;
use Database\Factories\Data\Names\PromotionNames;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * One promotion per name in PromotionNames, with SEO texts and slugs. Products are attached later.
     */
    public function run(): void
    {
        foreach (PromotionNames::get() as $localeNames) {
            $promotion = Promotion::factory()->create(['name' => $localeNames]);

            $promotion->seoMeta()->updateOrCreate([], [
                'h1' => $localeNames,
                'seo_text_top' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 200, 500),
                'seo_text_bottom' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 900, 1500),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $promotion->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }
        }
    }
}
