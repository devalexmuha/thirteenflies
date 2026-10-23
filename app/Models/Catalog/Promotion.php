<?php

namespace App\Models\Catalog;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Catalog\PromotionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    /** @use HasFactory<PromotionFactory> */
    use HasFactory, HasMedia, HasSeoMeta, HasSlug, Translatable;

    protected $guarded = [];

    public $timestamps = false;

    public array $translatable = ['name'];

    protected static function booted()
    {
        static::saving(function (Promotion $promotion) {
            $promotion->sale_starts_at ??= now();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
