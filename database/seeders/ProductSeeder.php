<?php

namespace Database\Seeders;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Catalog\Promotion;
use App\Models\Filters\AttributeValue;
use Database\Factories\Data\AttributeValues\ProductAttributeValues;
use Database\Factories\Data\Names\ProductNames;
use Database\Factories\Data\Relations\CategoryProductRelations;
use Database\Factories\Data\Relations\ProductBrandRelation;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * One product per name in ProductNames, with descriptions, slugs, category, brand and attribute values.
     * Then 10-15% of the products get a discount and another 10-15% a promotion.
     */
    public function run(): void
    {
        $categoryIds = Category::all()
            ->mapWithKeys(fn (Category $category) => [$category->getTranslation('name', 'en') => $category->id])
            ->all();
        $brandIds = Brand::pluck('id', 'name')->all();
        $valueIds = AttributeValue::with('attribute')->get()
            ->mapWithKeys(fn (AttributeValue $value) => ["{$value->attribute->slug}:{$value->slug}" => $value->id])
            ->all();

        $categoryOf = [];

        foreach (CategoryProductRelations::get() as $categoryName => $productNames) {
            foreach ($productNames as $productName) {
                $categoryOf[$productName] = $categoryName;
            }
        }

        $brandOf = ProductBrandRelation::get();
        $attributeValues = ProductAttributeValues::get();

        foreach (ProductNames::get() as $localeNames) {
            $name = $localeNames['en'];

            $product = Product::factory()->create([
                'name' => $localeNames,
                'brand_id' => $brandIds[$brandOf[$name]],
                'short_description' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 150, 300),
                'description' => TextBuilder::forLocales(CatalogSentences::get(), $localeNames, 500, 1000),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $product->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }

            $product->categories()->attach($categoryIds[$categoryOf[$name]]);

            $product->attributeValues()->attach(array_map(
                fn (string $attribute, string $value) => $valueIds[Str::slug($attribute).':'.Str::slug($value)],
                array_keys($attributeValues[$name]),
                $attributeValues[$name],
            ));
        }

        $products = Product::all()->shuffle();
        $total = $products->count();

        $this->assignDiscounts($products->splice(0, $this->share($total)));
        $this->assignPromotions($products->splice(0, $this->share($total)));
    }

    /**
     * Each product gets a random discount and a price 10-25% below its regular one.
     *
     * @param  Collection<int, Product>  $products
     */
    private function assignDiscounts(Collection $products): void
    {
        $discounts = Discount::all();

        foreach ($products as $product) {
            $product->update([
                'discount_id' => $discounts->random()->id,
                'is_discounted' => true,
                'discount_price' => (int) round($product->price * (1 - fake()->numberBetween(10, 25) / 100)),
            ]);
        }
    }

    /**
     * Each product joins a random promotion.
     *
     * @param  Collection<int, Product>  $products
     */
    private function assignPromotions(Collection $products): void
    {
        $promotions = Promotion::all();

        foreach ($products as $product) {
            $product->promotions()->attach($promotions->random()->id);
        }
    }

    /**
     * A random 10-15% of the total.
     */
    private function share(int $total): int
    {
        return (int) round($total * fake()->numberBetween(10, 15) / 100);
    }
}
