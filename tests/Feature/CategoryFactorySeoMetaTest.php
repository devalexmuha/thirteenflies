<?php

use App\Models\Catalog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('fills seo meta for every locale of the category name', function () {
    $category = Category::factory()->create([
        'name' => ['en' => 'Guitars', 'es' => 'Guitarras', 'uk' => 'Гітари', 'ru' => 'Гитары'],
    ]);

    $seoMeta = $category->seoMeta;

    expect($seoMeta->getTranslation('meta_title', 'en'))->toBe('Shop Guitars Online - Thirteen Flies')
        ->and($seoMeta->getTranslation('meta_title', 'es'))->toBe('Compra Guitarras en línea - Thirteen Flies')
        ->and($seoMeta->getTranslation('h1', 'uk'))->toBe('Гітари')
        ->and($seoMeta->getTranslation('meta_description', 'ru'))->toContain('Гитары');
});

it('fills top and bottom seo texts within their length limits', function () {
    $seoMeta = Category::factory()->create(['name' => ['en' => 'Guitars']])->seoMeta;

    $top = strip_tags($seoMeta->getTranslation('seo_text_top', 'en'));
    $bottom = strip_tags($seoMeta->getTranslation('seo_text_bottom', 'en'));

    expect(mb_strlen($top))->toBeLessThanOrEqual(300)->toBeGreaterThan(40)
        ->and(mb_strlen($bottom))->toBeLessThanOrEqual(1300)->toBeGreaterThan(500)
        ->and($seoMeta->getTranslation('seo_text_top', 'en'))->toStartWith('<p>');
});
