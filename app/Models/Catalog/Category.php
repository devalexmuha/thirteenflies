<?php

namespace App\Models\Catalog;

use App\Models\Filters\FilterPage;
use App\Models\Seo\ProductMetaTemplate;
use App\Models\Traits\HasFilterAttributes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Catalog\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, HasFilterAttributes, HasMedia, HasSeoMeta, HasSlug, NodeTrait, Translatable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public array $translatable = ['name'];

    protected static function booted(): void
    {
        static::deleting(function ($model): void {
            $model->filterPages()->each->delete();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function filterPages(): MorphMany
    {
        return $this->morphMany(FilterPage::class, 'filterable');
    }

    public function productMetaTemplates(): HasOne
    {
        return $this->hasOne(ProductMetaTemplate::class);
    }
}
