<?php

namespace App\Services;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Product;
use App\Models\Filters\Attribute;
use App\Models\Filters\AttributeValue;
use App\Models\Filters\FilterPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FilterListing
{
    public function __construct(private ProductListing $productListing) {}

    /**
     * Everything the client needs to build the filters of a product list: price range and brands of its products,
     * attributes with the values its products really have, and the ready-made filter pages (flt key + slug).
     * Attributes and filter pages are empty for models which do not have them (promotions, discounts).
     *
     * @return array{price: array, brands: array, attributes: array, pages: array}
     */
    public function forModel(Model $model): array
    {
        $productIds = $this->productListing->productsOf($model)->active()->select('products.id');

        return [
            'price' => $this->priceRange($productIds),
            'brands' => $this->brands($productIds),
            'attributes' => $this->attributes($model, $productIds),
            'filter_pages' => $this->pages($model),
        ];
    }

    /**
     * @return array{min: float, max: float}
     */
    private function priceRange(Builder|Relation $productIds): array
    {
        $effectivePrice = $this->productListing->effectivePrice();

        $range = Product::query()
            ->whereIn('products.id', $productIds)
            ->selectRaw("min({$effectivePrice}) as min, max({$effectivePrice}) as max")
            ->first();

        // the database keeps cents, the client works with dollars
        return ['min' => round($range->min / 100, 2), 'max' => round($range->max / 100, 2)];
    }

    private function brands(Builder|Relation $productIds): array
    {
        return Brand::query()
            ->active()
            ->whereHas('products', fn ($products) => $products->whereIn('products.id', $productIds))
            ->with('slug')
            ->get()
            ->map(fn (Brand $brand) => ['name' => $brand->name, 'slug' => $brand->slug?->slug])
            ->all();
    }

    private function attributes(Model $model, Builder|Relation $productIds): array
    {
        if (! method_exists($model, 'filterAttributes')) {
            return [];
        }

        return $model->filterAttributes()
            ->with(['values' => fn ($values) => $values->whereHas('products', fn ($products) => $products->whereIn('products.id', $productIds))])
            ->get()
            ->filter(fn (Attribute $attribute) => $attribute->values->isNotEmpty())
            ->map(fn (Attribute $attribute) => [
                'name' => $attribute->name,
                'slug' => $attribute->slug,
                'values' => $attribute->values
                    ->map(fn (AttributeValue $value) => ['value' => $value->value, 'slug' => $value->slug])
                    ->all(),
            ])
            ->values()
            ->all();
    }

    private function pages(Model $model): array
    {
        if (! method_exists($model, 'filterPages')) {
            return [];
        }

        return $model->filterPages()
            ->active()
            ->with('slug')
            ->get()
            ->map(fn (FilterPage $page) => ['flt_key' => $page->flt_key, 'slug' => $page->slug?->slug])
            ->all();
    }
}
