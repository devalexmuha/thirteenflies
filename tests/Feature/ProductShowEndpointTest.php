<?php

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Catalog\Promotion;
use App\Models\Filters\Attribute;
use App\Models\Filters\AttributeValue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function productWithSlug(string $slug, array $attributes = []): Product
{
    $product = Product::factory()->create($attributes + [
        'name' => ['en' => 'Les Paul'],
        'price' => 200,
        'stock_qty' => 3,
        'is_active' => true,
    ]);
    $product->slugs()->create(['locale' => 'en', 'slug' => $slug]);

    return $product;
}

it('shows the product by slug on /api/products/{slug}', function () {
    productWithSlug('les-paul');

    $this->getJson('/api/products/les-paul')
        ->assertOk()
        ->assertJsonPath('data.name', 'Les Paul')
        ->assertJsonPath('data.slug.slug', 'les-paul')
        ->assertJsonPath('data.price', 200)
        ->assertJsonPath('data.in_stock', true);
});

it('answers 404 json for an unknown product slug', function () {
    $this->getJson('/api/products/nope')->assertNotFound();
});

it('loads the brand, categories, attributes and videos of the product', function () {
    $product = productWithSlug('les-paul', ['brand_id' => Brand::factory()->create(['name' => 'Gibson'])->id]);
    $product->brand->slugs()->create(['locale' => 'en', 'slug' => 'gibson']);

    $category = Category::factory()->create(['name' => ['en' => 'Guitars']]);
    $category->slugs()->create(['locale' => 'en', 'slug' => 'guitars']);
    $product->categories()->attach($category);

    $attribute = Attribute::create(['name' => ['en' => 'Body Type']]);
    $product->attributeValues()->attach(AttributeValue::create(['attribute_id' => $attribute->id, 'value' => ['en' => 'Solid Body']]));

    $product->videos()->create(['video_link' => 'https://youtu.be/abc']);

    $this->getJson('/api/products/les-paul')
        ->assertOk()
        ->assertJsonPath('data.brand.name', 'Gibson')
        ->assertJsonPath('data.brand.slug.slug', 'gibson')
        ->assertJsonPath('data.categories.0.slug.slug', 'guitars')
        ->assertJsonPath('data.attributes.0.name', 'Body Type')
        ->assertJsonPath('data.attributes.0.value', 'Solid Body')
        ->assertJsonPath('data.videos.0', 'https://youtu.be/abc');
});

it('shows the best active promotion of the product', function () {
    $product = productWithSlug('les-paul', ['price' => 400]);
    $product->promotions()->attach(Promotion::factory()->create(['name' => ['en' => 'Small'], 'discount_rate' => 10]));
    $product->promotions()->attach(Promotion::factory()->create(['name' => ['en' => 'Big'], 'discount_rate' => 25]));
    $product->promotions()->attach(Promotion::factory()->create(['name' => ['en' => 'Off'], 'discount_rate' => 90, 'is_active' => false]));

    $this->getJson('/api/products/les-paul')
        ->assertOk()
        ->assertJsonPath('data.promotion.name', 'Big')
        ->assertJsonPath('data.promotion.rate', 25)
        ->assertJsonPath('data.promotion.promotion_price', 300);
});

it('returns promotion null when the product has no active promotion', function () {
    productWithSlug('les-paul');

    $this->getJson('/api/products/les-paul')->assertOk()->assertJsonPath('data.promotion', null);
});

it('lists the active related products as cards', function () {
    $product = productWithSlug('les-paul');
    $related = productWithSlug('sg', ['name' => ['en' => 'SG']]);
    $hidden = productWithSlug('hidden', ['name' => ['en' => 'Hidden'], 'is_active' => false]);
    $product->relatedProducts()->attach([$related->id, $hidden->id]);

    $this->getJson('/api/products/les-paul')
        ->assertOk()
        ->assertJsonCount(1, 'data.related_products')
        ->assertJsonPath('data.related_products.0.name', 'SG')
        ->assertJsonPath('data.related_products.0.slug.slug', 'sg');
});

it('returns the slugs of every locale', function () {
    $product = productWithSlug('les-paul');
    $product->slugs()->create(['locale' => 'es', 'slug' => 'les-paul-es']);

    $this->getJson('/api/products/les-paul')->assertOk()->assertJsonCount(2, 'data.slugs');
    $this->getJson('/api/products/les-paul-es?locale=es')->assertOk()->assertJsonPath('data.slug.locale', 'es');
});
