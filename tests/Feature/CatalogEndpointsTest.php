<?php

use App\Enums\DiscountType;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Promotion;
use App\Models\Seo\SeoTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * A record with an english slug and an SEO meta row, like the seeders create them.
 *
 * @param  class-string<Model>  $model
 * @param  array<string, mixed>  $attributes
 */
function catalogRecord(string $model, string $slug, array $attributes = []): Model
{
    // discounts have a unique type, so every new discount takes the next free one
    if ($model === Discount::class) {
        $attributes += ['type' => DiscountType::cases()[Discount::count()]->value];
    }

    $record = $model::factory()->create($attributes);
    $record->slugs()->create(['locale' => 'en', 'slug' => $slug]);
    $record->seoMeta()->create(['h1' => ['en' => "{$slug} h1"]]);

    return $record;
}

dataset('catalog', [
    'categories' => ['categories', Category::class, ['name' => ['en' => 'Pianos']]],
    'brands' => ['brands', Brand::class, ['name' => 'Yamaha']],
    'discounts' => ['discounts', Discount::class, ['name' => ['en' => 'Open Box']]],
    'promotions' => ['promotions', Promotion::class, ['name' => ['en' => 'Summer Sale']]],
]);

it('lists records with their slug on /api/{route}', function (string $route, string $model, array $attributes) {
    catalogRecord($model, 'first', $attributes);
    catalogRecord($model, 'second', $attributes);

    $this->getJson("/api/{$route}")
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['slug' => 'first'])
        ->assertJsonFragment(['slug' => 'second']);
})->with('catalog');

it('shows one record by slug with slugs and seo on /api/{route}/{slug}', function (string $route, string $model, array $attributes) {
    catalogRecord($model, 'my-slug', $attributes);

    $this->getJson("/api/{$route}/my-slug")
        ->assertOk()
        ->assertJsonPath('data.slug.slug', 'my-slug')
        ->assertJsonPath('data.slug.locale', 'en')
        ->assertJsonPath('data.seo.h1', 'my-slug h1')
        ->assertJsonCount(1, 'data.slugs');
})->with('catalog');

it('answers 404 json for an unknown slug on /api/{route}/{slug}', function (string $route, string $model, array $attributes) {
    $this->getJson("/api/{$route}/nope")
        ->assertNotFound()
        ->assertJson(['message' => 'Sorry dude, there is no data for your request.']);
})->with('catalog');

it('finds a record by the slug of the requested locale', function (string $route, string $model, array $attributes) {
    $record = catalogRecord($model, 'piano', $attributes);
    $record->slugs()->create(['locale' => 'es', 'slug' => 'piano-es']);

    $this->getJson("/api/{$route}/piano-es?locale=es")
        ->assertOk()
        ->assertJsonPath('data.slug.slug', 'piano-es');

    // the spanish slug does not exist in english
    $this->getJson("/api/{$route}/piano-es")->assertNotFound();
})->with('catalog');

it('hides inactive records in the list', function (string $route, string $model, array $attributes) {
    catalogRecord($model, 'visible', $attributes);
    catalogRecord($model, 'hidden', $attributes + ['is_active' => false]);

    $this->getJson("/api/{$route}")
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['slug' => 'visible']);
})->with([
    'categories' => ['categories', Category::class, ['name' => ['en' => 'Pianos']]],
    'brands' => ['brands', Brand::class, ['name' => 'Yamaha']],
    'promotions' => ['promotions', Promotion::class, ['name' => ['en' => 'Summer Sale']]],
]);

it('returns the categories as a tree', function () {
    $parent = catalogRecord(Category::class, 'pianos', ['name' => ['en' => 'Pianos']]);
    $child = catalogRecord(Category::class, 'grand-pianos', ['name' => ['en' => 'Grand pianos']]);
    $child->appendToNode($parent)->save();

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug.slug', 'pianos')
        ->assertJsonPath('data.0.children.0.slug.slug', 'grand-pianos');
});

it('shows the category with breadcrumbs and active children', function () {
    $parent = catalogRecord(Category::class, 'pianos', ['name' => ['en' => 'Pianos']]);
    $child = catalogRecord(Category::class, 'grand-pianos', ['name' => ['en' => 'Grand pianos']]);
    $child->appendToNode($parent)->save();

    $this->getJson('/api/categories/grand-pianos')
        ->assertOk()
        ->assertJsonPath('data.breadcrumbs.0.slug.slug', 'pianos');

    $this->getJson('/api/categories/pianos')
        ->assertOk()
        ->assertJsonPath('data.children.0.slug.slug', 'grand-pianos');
});

it('fills blank seo fields of a brand from the seo template', function () {
    SeoTemplate::create([
        'page_type' => 'brand',
        'meta_title' => ['en' => '{name} Instruments'],
    ]);
    $brand = catalogRecord(Brand::class, 'yamaha', ['name' => 'Yamaha']);

    $this->getJson('/api/brands/yamaha')
        ->assertOk()
        ->assertJsonPath('data.seo.meta_title', 'Yamaha Instruments');
});

it('returns the promotion rate and dates', function () {
    catalogRecord(Promotion::class, 'summer-sale', ['name' => ['en' => 'Summer Sale'], 'discount_rate' => 25]);

    $this->getJson('/api/promotions/summer-sale')
        ->assertOk()
        ->assertJsonPath('data.rate', 25)
        ->assertJsonStructure(['data' => ['starts_at', 'ends_at']]);
});
