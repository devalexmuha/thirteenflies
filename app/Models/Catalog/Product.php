<?php

namespace App\Models\Catalog;

use App\Models\Account\User;
use App\Models\Filters\AttributeValue;
use App\Models\Sales\CartItem;
use App\Models\Sales\OrderItem;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasScope;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Catalog\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, HasMedia, HasScope, HasSeoMeta, HasSlug, Translatable;

    protected $guarded = [];

    public array $translatable = ['name', 'short_description', 'description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            $product->in_stock = $product->stock_qty > 0;
        });
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value / 100,
            set: fn (string $value) => $value * 100,
        );
    }

    public function discountPrice(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value === null ? null : $value / 100,
            set: fn (?string $value) => $value === null ? null : $value * 100,
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class);
    }

    /**
     * The loaded promotion with the highest discount rate, with the discounted "price" added to it.
     * Load the promotions first, e.g. with(['promotions' => fn ($q) => $q->active()]).
     */
    public function bestPromotion(): ?Promotion
    {
        $promotion = $this->promotions->sortByDesc('discount_rate')->first();

        $promotion?->setAttribute('promotion_price', round($this->price * (1 - $promotion->discount_rate / 100), 2));

        return $promotion;
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'product_id', 'related_product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    //    public function attributes(): morphToMany
    //    {
    //        return $this->morphToMany(Attribute::class, 'attributable');
    //    }

    public function attributeValues(): MorphToMany
    {
        return $this->morphToMany(AttributeValue::class, 'attribute_valuable');
    }

    public function wishedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeOnSale(Builder $query): void
    {
        $query->whereNotNull('sale_price')
            ->where(fn ($q) => $q->whereNull('sale_starts_at')->orWhere('sale_starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('sale_ends_at')->orWhere('sale_ends_at', '>=', now()));
    }

    public function scopeInCategoryTree(Builder $query, Category $category): void
    {
        $ids = $category->descendants()->pluck('id')->push($category->id);

        $query->whereHas('categories', fn ($q) => $q->whereIn('category_id', $ids));
    }

    public function refreshRating(): void
    {
        $stats = $this->reviews()
            ->selectRaw('COUNT(*) as total, AVG(rating) as average')
            ->first();

        $this->updateQuietly([
            'reviews_count' => $stats->total,
            'rating_avg' => $stats->total ? round($stats->average, 2) : null,
        ]);
    }
}
