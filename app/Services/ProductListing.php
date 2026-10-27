<?php

namespace App\Services;

use App\Http\Requests\ListProductsRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ProductListing
{
    /**
     * Products of the parent model (category, brand, promotion, discount) or all products when there is no parent,
     * filtered, sorted and paginated.
     */
    public function paginate(?Model $parentModel, ListProductsRequest $listProductsRequest): LengthAwarePaginator
    {
        $validated = $listProductsRequest->validated();

        // a category also lists the products of its child categories, other parents use their products() relation
        $products = match (true) {
            $parentModel === null => Product::query(),
            $parentModel instanceof Category => Product::query()->inCategoryTree($parentModel),
            default => $parentModel->products(),
        };

        return $products
            ->active()
            ->tap(fn ($query) => $this->applyFilters($query, $parentModel, $validated['filter'] ?? []))
            ->tap(fn ($query) => $this->applySorting($query, $validated['sort'] ?? 'newest'))
            ->with(['slug', 'brand', 'discount', 'media', 'promotions' => fn ($query) => $query->active()])
            ->paginate($validated['per_page'] ?? 24)
            ->withQueryString();
    }

    /**
     * @param  array<string, string>  $filters  ?filter[brand]=yamaha&filter[price_max]=900&filter[finish]=polished-ebony
     */
    private function applyFilters(Builder|Relation $query, ?Model $parentModel, array $filters): void
    {
        $query
            ->when(isset($filters['brand']), fn ($query) => $query->whereHas('brand.slugs', fn ($slugs) => $slugs
                ->whereIn('slug', explode(',', $filters['brand']))
                ->where('locale', app()->getLocale())))
            // the database keeps cents, the client sends dollars
            ->when(isset($filters['price_min']), fn ($query) => $query->whereRaw($this->effectivePrice().' >= ?', [$filters['price_min'] * 100]))
            ->when(isset($filters['price_max']), fn ($query) => $query->whereRaw($this->effectivePrice().' <= ?', [$filters['price_max'] * 100]))
            ->when(! empty($filters['in_stock']), fn ($query) => $query->where('in_stock', true))
            ->when(! empty($filters['on_sale']), fn ($query) => $query->where('is_discounted', true));

        // only attributes assigned to the parent can be used, everything else in filter[] is ignored
        $allowedAttributes = $parentModel && method_exists($parentModel, 'filterAttributes')
            ? $parentModel->filterAttributes()->pluck('slug')
            : collect();

        foreach ($allowedAttributes as $attributeSlug) {
            $query->when(isset($filters[$attributeSlug]), fn ($query) => $query->whereHas('attributeValues', fn ($values) => $values
                ->whereIn('slug', explode(',', $filters[$attributeSlug]))
                ->whereRelation('attribute', 'slug', $attributeSlug)));
        }
    }

    private function applySorting(Builder|Relation $query, string $sorting): void
    {
        match ($sorting) {
            'price_asc' => $query->orderByRaw($this->effectivePrice().' asc'),
            'price_desc' => $query->orderByRaw($this->effectivePrice().' desc'),
            'rating' => $query->orderByDesc('products.avr_rating'),
            default => $query->orderByDesc('products.created_at'),
        };
    }

    /**
     * SQL for the lowest price the customer can pay: regular price, discount price or promotion price.
     * The promotion price is the regular price minus the highest active promotion rate, like Product::bestPromotion().
     */
    private function effectivePrice(): string
    {
        $bestPromotionRate = 'select max(promotions.discount_rate) from promotions
            inner join product_promotion on product_promotion.promotion_id = promotions.id
            where product_promotion.product_id = products.id and promotions.is_active = 1';

        return "LEAST(COALESCE(products.discount_price, products.price), products.price * (1 - COALESCE(({$bestPromotionRate}), 0) / 100))";
    }
}
