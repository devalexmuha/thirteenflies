<?php

use App\Enums\Locale;
use App\Enums\SeoTemplateType;
use Database\Factories\Data\AttributeValues\BrandAttributeValues;
use Database\Factories\Data\AttributeValues\CategoryAttributeValues;
use Database\Factories\Data\AttributeValues\ProductAttributeValues;
use Database\Factories\Data\Names\ArticleNames;
use Database\Factories\Data\Names\AuthorPositions;
use Database\Factories\Data\Names\BrandNames;
use Database\Factories\Data\Names\CategoryNames;
use Database\Factories\Data\Names\DiscountNames;
use Database\Factories\Data\Names\PageNames;
use Database\Factories\Data\Names\ProductNames;
use Database\Factories\Data\Names\PromotionNames;
use Database\Factories\Data\Names\ServiceNames;
use Database\Factories\Data\Relations\CategoryProductRelations;
use Database\Factories\Data\Relations\CategoryRelations;
use Database\Factories\Data\Relations\ProductBrandRelation;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Data\Seo\SeoTemplates;

function productCategories(): array
{
    $categoryOf = [];

    foreach (CategoryProductRelations::get() as $category => $products) {
        foreach ($products as $product) {
            $categoryOf[$product][] = $category;
        }
    }

    return $categoryOf;
}

it('has a non-empty name in every locale', function () {
    $locales = array_column(Locale::cases(), 'value');

    $classes = [
        'categories' => CategoryNames::get(),
        'products' => ProductNames::get(),
        'promotions' => PromotionNames::get(),
        'discounts' => array_values(DiscountNames::get()),
        'articles' => ArticleNames::get(),
        'services' => ServiceNames::get(),
        'author positions' => AuthorPositions::get(),
        'single pages' => PageNames::get(),
        'template pages' => array_values(PageNames::templates()),
    ];

    foreach ($classes as $label => $list) {
        foreach ($list as $localeNames) {
            expect(array_keys($localeNames) === $locales && count(array_filter($localeNames)) === count($locales))
                ->toBeTrue("{$label}: ".json_encode($localeNames, JSON_UNESCAPED_UNICODE));
        }
    }
});

it('has unique English product names', function () {
    $names = array_column(ProductNames::get(), 'en');

    expect($names)->toHaveCount(count(array_unique($names)));
});

it('lists every parent category before its children', function () {
    $created = [];

    foreach (array_column(CategoryNames::get(), 'en') as $name) {
        $parent = CategoryRelations::get()[$name] ?? null;

        expect($parent === null || in_array($parent, $created, true))->toBeTrue("{$name} comes before its parent");

        $created[] = $name;
    }
});

it('puts every product in exactly one known category and gives it exactly one known brand', function () {
    $categoryOf = productCategories();
    $categoryNames = array_column(CategoryNames::get(), 'en');

    foreach (array_keys(CategoryProductRelations::get()) as $category) {
        expect(in_array($category, $categoryNames, true))->toBeTrue("unknown category {$category}");
    }

    foreach (array_column(ProductNames::get(), 'en') as $product) {
        expect(count($categoryOf[$product] ?? []))->toBe(1, "{$product}: categories")
            ->and(in_array(ProductBrandRelation::get()[$product] ?? null, BrandNames::get(), true))->toBeTrue("{$product}: brand")
            ->and(isset(ProductAttributeValues::get()[$product]))->toBeTrue("{$product}: attribute values");
    }

    expect(count($categoryOf))->toBe(count(ProductNames::get()));
});

it('gives every category and every brand at least one product', function () {
    expect(array_filter(CategoryProductRelations::get()))->toHaveCount(count(CategoryNames::get()))
        ->and(array_unique(ProductBrandRelation::get()))->toHaveCount(count(BrandNames::get()));
});

it('gives each product only values listed for its category or brand, and every brand attribute', function () {
    $categoryOf = productCategories();

    foreach (ProductAttributeValues::get() as $product => $attributes) {
        $category = CategoryAttributeValues::get()[$categoryOf[$product][0]];
        $brand = BrandAttributeValues::get()[ProductBrandRelation::get()[$product]];

        foreach ($attributes as $attribute => $value) {
            expect(in_array($value, $category[$attribute] ?? $brand[$attribute] ?? [], true))
                ->toBeTrue("{$product}: {$attribute} = {$value}");
        }

        foreach (array_keys($brand) as $brandAttribute) {
            expect(isset($attributes[$brandAttribute]))->toBeTrue("{$product}: missing {$brandAttribute}");
        }
    }
});

it('has attribute values for every brand and only for known categories', function () {
    expect(array_keys(BrandAttributeValues::get()))->toEqualCanonicalizing(BrandNames::get())
        ->and(array_diff(array_keys(CategoryAttributeValues::get()), array_column(CategoryNames::get(), 'en')))->toBeEmpty();
});

it('has a complete SEO template for every page type', function () {
    $locales = array_column(Locale::cases(), 'value');

    foreach (SeoTemplateType::cases() as $type) {
        $template = SeoTemplates::get()[$type->value];

        foreach (['title', 'description', 'h1', 'alt'] as $field) {
            expect(array_keys($template[$field]) === $locales)->toBeTrue("{$type->value}.{$field}");
        }
    }
});

it('has the same number of sentences in every locale', function () {
    $locales = array_column(Locale::cases(), 'value');

    foreach ([CatalogSentences::get(), ContentSentences::get()] as $sentences) {
        expect(array_keys($sentences) === $locales)->toBeTrue()
            ->and(array_unique(array_map('count', $sentences)))->toHaveCount(1);
    }
});
