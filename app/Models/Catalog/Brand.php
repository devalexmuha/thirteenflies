<?php

namespace App\Models\Catalog;

use App\Models\Filters\Attribute;
use App\Models\Filters\FilterPage;
use App\Models\Traits\HasFilterAttributes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory, Translatable, HasSeoMeta, HasFilterAttributes, HasSlug, HasMedia;

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
