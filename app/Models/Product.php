<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    public array $translatable = ['slug', 'name', 'short_description', 'description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
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

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
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
