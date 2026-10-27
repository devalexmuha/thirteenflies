<?php

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Catalog\Promotion;
use App\Models\Filters\Attribute;
use App\Models\Filters\AttributeValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    // MySQL has LEAST(), SQLite does not: teach the in-memory test database the same function
    $pdo = DB::connection()->getPdo();
    $leastOf = fn (...$values) => min($values);

    method_exists($pdo, 'createFunction')
        ? $pdo->createFunction('LEAST', $leastOf, -1)
        : $pdo->sqliteCreateFunction('LEAST', $leastOf, -1);

    $this->category = Category::factory()->create(['name' => ['en' => 'Pianos']]);
    $this->category->slugs()->create(['locale' => 'en', 'slug' => 'pianos']);
});

/**
 * An active product in the category. Prices are in dollars, like the API shows them.
 *
 * @param  array<string, mixed>  $attributes
 */
function categoryProduct(array $attributes = [], ?Category $category = null): Product
{
    $product = Product::factory()->create($attributes + [
        'name' => ['en' => 'Piano'],
        'price' => 100,
        'stock_qty' => 5,
        'is_active' => true,
    ]);

    $product->categories()->attach($category ?? test()->category);

    return $product;
}

function brandWithSlug(string $slug): Brand
{
    $brand = Brand::factory()->create(['name' => ucfirst($slug)]);
    $brand->slugs()->create(['locale' => 'en', 'slug' => $slug]);

    return $brand;
}

function promotionFor(Product $product, int $rate, bool $active = true): Promotion
{
    $promotion = Promotion::factory()->create(['name' => ['en' => 'Sale'], 'discount_rate' => $rate, 'is_active' => $active]);
    $product->promotions()->attach($promotion);

    return $promotion;
}

/** The ids of the products in the response, in the order the API returned them. */
function listedIds($response): array
{
    return collect($response->json('data'))->pluck('id')->all();
}

const PRODUCTS = '/api/categories/pianos/products';

// ---- scope: every parent lists only its own products --------------------------------------------

dataset('parents', ['categories', 'brands', 'discounts', 'promotions']);

it('lists only the products of the parent on /api/{parent}/{slug}/products', function (string $type) {
    [$parent, $addProduct] = match ($type) {
        'categories' => [$this->category, fn (array $attrs) => categoryProduct($attrs)],
        'brands' => [brandWithSlug('yamaha'), fn (array $attrs) => Product::factory()->create($attrs + ['brand_id' => Brand::first()->id])],
        'discounts' => (function () {
            $discount = Discount::factory()->create(['name' => ['en' => 'Open Box']]);
            $discount->slugs()->create(['locale' => 'en', 'slug' => 'open-box']);

            return [$discount, fn (array $attrs) => Product::factory()->create($attrs + ['discount_id' => $discount->id])];
        })(),
        'promotions' => (function () {
            $promotion = Promotion::factory()->create(['name' => ['en' => 'Sale']]);
            $promotion->slugs()->create(['locale' => 'en', 'slug' => 'sale']);

            return [$promotion, function (array $attrs) use ($promotion) {
                $product = Product::factory()->create($attrs);
                $product->promotions()->attach($promotion);

                return $product;
            }];
        })(),
    };

    $base = ['name' => ['en' => 'Piano'], 'price' => 100, 'stock_qty' => 5, 'is_active' => true];
    $inside = [$addProduct($base), $addProduct($base)];
    $addProduct(['is_active' => false] + $base);          // inactive product of the same parent
    Product::factory()->create($base);                      // product of nobody

    $slug = $parent->slugs()->value('slug');

    $this->getJson("/api/{$type}/{$slug}/products")
        ->assertOk()
        ->assertJsonPath('meta.total', 2)
        ->assertJsonCount(2, 'data');

    expect(listedIds($this->getJson("/api/{$type}/{$slug}/products")))->toEqualCanonicalizing(collect($inside)->pluck('id')->all());
})->with('parents');

it('lists the products of the child categories too', function () {
    $child = Category::factory()->create(['name' => ['en' => 'Grand pianos']]);
    $child->appendToNode($this->category)->save();

    $parentProduct = categoryProduct();
    $childProduct = categoryProduct([], $child);

    expect(listedIds($this->getJson(PRODUCTS)))->toEqualCanonicalizing([$parentProduct->id, $childProduct->id]);
});

it('returns the product card fields', function () {
    $product = categoryProduct(['price' => 200, 'stock_qty' => 3]);
    promotionFor($product, 25);

    $this->getJson(PRODUCTS)
        ->assertOk()
        ->assertJsonPath('data.0.price', 200)
        ->assertJsonPath('data.0.in_stock', true)
        ->assertJsonPath('data.0.promotion.rate', 25)
        ->assertJsonPath('data.0.promotion.promotion_price', 150);
});

// ---- filters ----------------------------------------------------------------------------------

it('filters by brand slug and accepts several brands', function () {
    $yamaha = categoryProduct(['brand_id' => brandWithSlug('yamaha')->id]);
    $steinway = categoryProduct(['brand_id' => brandWithSlug('steinway')->id]);
    categoryProduct();

    expect(listedIds($this->getJson(PRODUCTS.'?filter[brand]=yamaha')))->toBe([$yamaha->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?filter[brand]=yamaha,steinway')))->toEqualCanonicalizing([$yamaha->id, $steinway->id]);
});

it('filters by price in dollars', function () {
    categoryProduct(['price' => 100]);
    $middle = categoryProduct(['price' => 200]);
    categoryProduct(['price' => 300]);

    expect(listedIds($this->getJson(PRODUCTS.'?filter[price_min]=150&filter[price_max]=250')))->toBe([$middle->id]);
});

it('accepts price_max without price_min', function () {
    $cheap = categoryProduct(['price' => 100]);
    categoryProduct(['price' => 300]);

    $this->getJson(PRODUCTS.'?filter[price_max]=150')->assertOk();
    expect(listedIds($this->getJson(PRODUCTS.'?filter[price_max]=150')))->toBe([$cheap->id]);
});

it('takes the discount price and the promotion price into account in the price filter', function () {
    $regular = categoryProduct(['price' => 400]);
    $discounted = categoryProduct(['price' => 400, 'discount_price' => 100, 'is_discounted' => true]);
    $promoted = categoryProduct(['price' => 400]);
    promotionFor($promoted, 50);                       // 200 with the promotion
    $inactivePromo = categoryProduct(['price' => 400]);
    promotionFor($inactivePromo, 90, active: false);   // an inactive promotion changes nothing

    expect(listedIds($this->getJson(PRODUCTS.'?filter[price_max]=250')))->toEqualCanonicalizing([$discounted->id, $promoted->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?filter[price_min]=300')))->toEqualCanonicalizing([$regular->id, $inactivePromo->id]);
});

it('filters by in_stock and on_sale and ignores a zero', function () {
    $available = categoryProduct(['stock_qty' => 5]);
    $soldOut = categoryProduct(['stock_qty' => 0]);
    $onSale = categoryProduct(['stock_qty' => 5, 'discount_price' => 50, 'is_discounted' => true]);

    expect(listedIds($this->getJson(PRODUCTS.'?filter[in_stock]=1')))->toEqualCanonicalizing([$available->id, $onSale->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?filter[on_sale]=1')))->toBe([$onSale->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?filter[in_stock]=0')))->toHaveCount(3);
});

describe('attribute filters', function () {
    beforeEach(function () {
        $this->finish = Attribute::create(['name' => ['en' => 'Finish']]);
        $this->pedals = Attribute::create(['name' => ['en' => 'Pedals']]);
        $this->category->filterAttributes()->attach([$this->finish->id, $this->pedals->id]);

        $value = fn (Attribute $attribute, string $name) => AttributeValue::create(['attribute_id' => $attribute->id, 'value' => ['en' => $name]]);
        $this->ebony = $value($this->finish, 'Polished Ebony');
        $this->walnut = $value($this->finish, 'Polished Walnut');
        $this->three = $value($this->pedals, '3');

        $this->ebonyThree = categoryProduct();
        $this->ebonyThree->attributeValues()->attach([$this->ebony->id, $this->three->id]);
        $this->ebonyOnly = categoryProduct();
        $this->ebonyOnly->attributeValues()->attach($this->ebony->id);
        $this->walnutOnly = categoryProduct();
        $this->walnutOnly->attributeValues()->attach($this->walnut->id);
    });

    it('filters by the value slug of an attribute', function () {
        expect(listedIds($this->getJson(PRODUCTS.'?filter[finish]=polished-walnut')))->toBe([$this->walnutOnly->id]);
    });

    it('matches any of several values of one attribute', function () {
        expect(listedIds($this->getJson(PRODUCTS.'?filter[finish]=polished-ebony,polished-walnut')))->toHaveCount(3);
    });

    it('matches all attributes together', function () {
        expect(listedIds($this->getJson(PRODUCTS.'?filter[finish]=polished-ebony&filter[pedals]=3')))->toBe([$this->ebonyThree->id]);
    });

    it('ignores an attribute that is not assigned to the category', function () {
        $color = Attribute::create(['name' => ['en' => 'Color']]);

        $this->getJson(PRODUCTS.'?filter[color]=black')
            ->assertOk()
            ->assertJsonPath('meta.total', 3);
    });

    it('does not mix a value with another attribute', function () {
        // "3" is a value of pedals, so it must not match when asked as a finish
        $this->getJson(PRODUCTS.'?filter[finish]=3')->assertOk()->assertJsonPath('meta.total', 0);
    });
});

// ---- sorting ----------------------------------------------------------------------------------

it('sorts by the lowest price the customer pays', function () {
    $plain = categoryProduct(['price' => 300]);
    $discounted = categoryProduct(['price' => 500, 'discount_price' => 100, 'is_discounted' => true]);
    $promoted = categoryProduct(['price' => 400]);
    promotionFor($promoted, 50);                       // 200

    expect(listedIds($this->getJson(PRODUCTS.'?sort=price_asc')))->toBe([$discounted->id, $promoted->id, $plain->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?sort=price_desc')))->toBe([$plain->id, $promoted->id, $discounted->id]);
});

it('uses the highest active promotion rate', function () {
    $product = categoryProduct(['price' => 400]);
    promotionFor($product, 10);
    promotionFor($product, 50);
    $other = categoryProduct(['price' => 250]);

    // 400 with 50% is 200, cheaper than 250
    expect(listedIds($this->getJson(PRODUCTS.'?sort=price_asc')))->toBe([$product->id, $other->id]);
});

it('sorts by newest by default and by rating', function () {
    $old = categoryProduct(['created_at' => now()->subDays(2), 'avr_rating' => 5]);
    $new = categoryProduct(['created_at' => now(), 'avr_rating' => 1]);

    expect(listedIds($this->getJson(PRODUCTS)))->toBe([$new->id, $old->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?sort=newest')))->toBe([$new->id, $old->id])
        ->and(listedIds($this->getJson(PRODUCTS.'?sort=rating')))->toBe([$old->id, $new->id]);
});

// ---- paging -----------------------------------------------------------------------------------

it('paginates with per_page and keeps the query in the page links', function () {
    foreach (range(1, 3) as $price) {
        categoryProduct(['price' => $price * 100]);
    }

    $response = $this->getJson(PRODUCTS.'?sort=price_asc&per_page=2&filter[in_stock]=1')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('meta.total', 3)
        ->assertJsonPath('meta.per_page', 2);

    $next = urldecode($response->json('links.next'));

    expect($next)->toContain('sort=price_asc')->toContain('filter[in_stock]=1')->toContain('page=2');
});

// ---- validation -------------------------------------------------------------------------------

it('rejects a bad query with 422', function (string $query, string $field) {
    $this->getJson(PRODUCTS.$query)->assertUnprocessable()->assertJsonValidationErrors($field);
})->with([
    'price_max is not a number' => ['?filter[price_max]=banana', 'filter.price_max'],
    'price_min is negative' => ['?filter[price_min]=-5', 'filter.price_min'],
    'price_max below price_min' => ['?filter[price_min]=500&filter[price_max]=100', 'filter.price_max'],
    'unknown sort' => ['?sort=cheapest', 'sort'],
    'page is zero' => ['?page=0', 'page'],
    'per_page is too big' => ['?per_page=101', 'per_page'],
    'in_stock is not 1 or 0' => ['?filter[in_stock]=yes', 'filter.in_stock'],
    'a filter value is an array' => ['?filter[finish][]=a', 'filter.finish'],
]);

it('shows a readable message for a bad price', function () {
    $this->getJson(PRODUCTS.'?filter[price_max]=banana')
        ->assertUnprocessable()
        ->assertJson(['errors' => ['filter.price_max' => ['Maximum price must be a number.']]]);
});

// ---- all products (no parent) -----------------------------------------------------------------

it('lists the active products of every parent on /api/products', function () {
    $inCategory = categoryProduct();
    $withoutParent = Product::factory()->create(['name' => ['en' => 'Loose'], 'price' => 100, 'stock_qty' => 1, 'is_active' => true]);
    Product::factory()->create(['name' => ['en' => 'Hidden'], 'price' => 100, 'stock_qty' => 1, 'is_active' => false]);

    $response = $this->getJson('/api/products')->assertOk()->assertJsonPath('meta.total', 2);

    expect(listedIds($response))->toEqualCanonicalizing([$inCategory->id, $withoutParent->id]);
});

it('returns product cards, not full product pages, on /api/products', function () {
    categoryProduct();

    $this->getJson('/api/products')
        ->assertOk()
        ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'price', 'promotion', 'in_stock', 'brand', 'images']], 'links', 'meta'])
        ->assertJsonMissingPath('data.0.description');
});

it('filters and sorts /api/products like the other listings', function () {
    $yamaha = categoryProduct(['price' => 300, 'brand_id' => brandWithSlug('yamaha')->id]);
    $cheapYamaha = categoryProduct(['price' => 100, 'brand_id' => Brand::first()->id]);
    categoryProduct(['price' => 200, 'brand_id' => brandWithSlug('steinway')->id]);

    expect(listedIds($this->getJson('/api/products?filter[brand]=yamaha&sort=price_asc')))->toBe([$cheapYamaha->id, $yamaha->id])
        ->and(listedIds($this->getJson('/api/products?filter[price_max]=150')))->toBe([$cheapYamaha->id]);
});

it('ignores attribute filters on /api/products because there is no parent to assign them', function () {
    categoryProduct();
    categoryProduct();

    $this->getJson('/api/products?filter[finish]=polished-ebony')->assertOk()->assertJsonPath('meta.total', 2);
});

it('rejects a bad query on /api/products with 422', function () {
    $this->getJson('/api/products?filter[price_max]=banana')->assertUnprocessable();
});
