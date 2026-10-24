<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use Database\Factories\Data\AttributeValues\CategoryAttributeValues;
use Database\Factories\Data\Names\CategoryNames;
use Database\Factories\Data\Relations\CategoryRelations;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Data\Seo\ProductCategorySeoTemplates;
use Database\Factories\Support\AttributeAssigner;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * One category per name in CategoryNames, with SEO texts, slugs, product meta templates and filter attributes.
     */
    public function run(): void
    {
        $relations = CategoryRelations::get();
        $ids = [];

        foreach (CategoryNames::get() as $localeNames) {
            $parent = $relations[$localeNames['en']] ?? null;

            $category = Category::factory()->create([
                'name' => $localeNames,
                'parent_id' => $parent ? $ids[$parent] : null,
            ]);

            $ids[$localeNames['en']] = $category->id;

            $category->seoMeta()->updateOrCreate([], [
                'h1' => $localeNames,
                'seo_text_top' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 200, 500),
                'seo_text_bottom' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 900, 1500),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $category->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }

            AttributeAssigner::assign($category, CategoryAttributeValues::get()[$localeNames['en']] ?? []);

            $templates = ProductCategorySeoTemplates::get();

            $category->productMetaTemplates()->updateOrCreate([], [
                'meta_title' => $templates['title'],
                'meta_description' => $this->fillCategoryName($templates['description'], $localeNames),
            ]);
        }
    }

    /**
     * @param  array<string, string>  $templates  locale => template
     * @param  array<string, string>  $localeNames  locale => category name
     * @return array<string, string> locale => template with {category_name} replaced
     */
    private function fillCategoryName(array $templates, array $localeNames): array
    {
        $filled = [];

        foreach ($templates as $locale => $template) {
            $filled[$locale] = strtr($template, ['{category_name}' => $localeNames[$locale]]);
        }

        return $filled;
    }
}
