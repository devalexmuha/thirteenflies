<?php

namespace App\Models\Catalog;

use App\Models\Filters\FilterPage;
use App\Models\Traits\HasActiveScope;
use App\Models\Traits\HasFilterAttributes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Catalog\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasActiveScope, HasFactory, HasFilterAttributes, HasMedia, HasSeoMeta, HasSlug, Translatable;

    protected $guarded = [];

    public array $translatable = ['description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::deleting(fn ($model) => $model->filterPages()->each->delete());
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function filterPages(): MorphMany
    {
        return $this->morphMany(FilterPage::class, 'filterable');
    }
}
