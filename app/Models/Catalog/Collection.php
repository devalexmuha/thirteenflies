<?php

namespace App\Models\Catalog;

use App\Models\Filters\Attribute;
use App\Models\Filters\FilterPage;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Collection extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory, HasTranslations, HasSeoMeta, HasSlug, HasMedia;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->products()->active();
    }

    public function attributes(): morphToMany
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }

    public function filterPages(): MorphMany
    {
        return $this->morphMany(FilterPage::class, 'filterable');
    }
}
