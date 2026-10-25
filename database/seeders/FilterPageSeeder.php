<?php

namespace Database\Seeders;

use App\Enums\Locale;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Filters\AttributeValue;
use App\Models\Filters\FilterPage;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class FilterPageSeeder extends Seeder
{
    /**
     * 15 filter pages: 8 for random categories and 7 for random brands. Each page filters by 1-2 attribute values.
     */
    public function run(): void
    {
        foreach (Category::inRandomOrder()->limit(8)->get() as $category) {
            $this->createPage($category, $category->getTranslations('name'));
        }

        foreach (Brand::inRandomOrder()->limit(7)->get() as $brand) {
            $this->createPage($brand, array_fill_keys(array_column(Locale::cases(), 'value'), $brand->name));
        }
    }

    /**
     * The values come from a random product of the category or brand, so the page always has products.
     *
     * @param  array<string, string>  $parentNames  locale => category or brand name
     */
    private function createPage(Model $filterable, array $parentNames): void
    {
        $values = $filterable->products()->inRandomOrder()->first()
            ->attributeValues()
            ->with('attribute')
            ->whereIn('attribute_id', $filterable->filterAttributes()->pluck('attributes.id'))
            ->get();

        $values = $values->random(min($values->count(), fake()->numberBetween(1, 2)));

        $key = $values->map(fn (AttributeValue $value) => "{$value->attribute->slug}={$value->slug}")->implode('+');

        $h1 = [];

        foreach ($parentNames as $locale => $parentName) {
            $h1[$locale] = $values
                ->map(fn (AttributeValue $value) => $value->getTranslation('value', $locale))
                ->prepend($parentName)
                ->implode(' ');
        }

        $page = FilterPage::factory()->for($filterable, 'filterable')->create([
            'flt_key' => "/flt/{$key}/",
        ]);

        $page->attributeValues()->attach($values->pluck('id'));

        $page->seoMeta()->updateOrCreate([], [
            'h1' => $h1,
            'seo_text_top' => TextBuilder::forLocales(CatalogSentences::get(), $h1, 200, 500),
            'seo_text_bottom' => TextBuilder::forLocales(CatalogSentences::get(), $h1, 900, 1500),
        ]);

        foreach ($h1 as $locale => $name) {
            $page->slugs()->create(['locale' => $locale, 'slug' => $name]);
        }
    }
}
