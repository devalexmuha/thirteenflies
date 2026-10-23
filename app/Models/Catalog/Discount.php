<?php

namespace App\Models\Catalog;

use App\Models\Filters\Attribute;
use App\Models\Filters\FilterPage;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Catalog\DiscountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Discount extends Model
{
    /** @use HasFactory<DiscountFactory> */
    use HasFactory, HasMedia, HasSeoMeta, HasSlug, Translatable;

    protected $guarded = [];

    public array $translatable = ['name'];

    protected static function booted(): void
    {
        static::deleting(function (Discount $discount): void {
            $discount->products()->update([
                'is_discounted' => false,
                'discount_price' => null,
            ]);
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->products()->active();
    }

    public function attributes(): MorphToMany
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }

    public function filterPages(): MorphMany
    {
        return $this->morphMany(FilterPage::class, 'filterable');
    }
}
