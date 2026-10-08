<?php

namespace App\Models\Catalog;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Promotion extends Model
{
    /** @use HasFactory<\Database\Factories\PromotionFactory> */
    use HasFactory, HasTranslations, HasSeoMeta, HasSlug, HasMedia;

    protected $guarded = [];
    public $timestamps = false;
    public array $translatable = ['name'];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
