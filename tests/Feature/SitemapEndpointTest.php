<?php

use App\Models\Catalog\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists every sitemap section with its page count', function () {
    $this->getJson('/api/sitemap')
        ->assertOk()
        ->assertJsonFragment(['name' => 'products', 'total' => 0, 'last_page' => 1])
        ->assertJsonCount(9, 'data');
});

it('returns the slugs of every locale for the active records of a section', function () {
    $brand = Brand::factory()->create(['name' => 'Yamaha']);
    $brand->slugs()->create(['slug' => 'yamaha', 'locale' => 'en']);
    Brand::factory()->create(['name' => 'Roland', 'is_active' => false]);

    $this->getJson('/api/sitemap/lookup?section=brands')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slugs.en', 'yamaha');
});

it('rejects an unknown section', function () {
    $this->getJson('/api/sitemap/lookup?section=nope')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('section');
});

it('keeps the section in the pagination links', function () {
    $this->getJson('/api/sitemap/lookup?section=brands')
        ->assertOk()
        ->assertJsonPath('meta.path', url('/api/sitemap/lookup'))
        ->assertJsonPath('links.first', url('/api/sitemap/lookup?section=brands&page=1'));
});
