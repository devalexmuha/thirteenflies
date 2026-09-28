<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class FilterPage extends Model
{
    /** @use HasFactory<\Database\Factories\FilterPageFactory> */
    use HasFactory, HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['filterable_type', 'filterable_id', 'brand_id', 'name', 'seo_path', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function filterable(): MorphTo
    {
        return $this->morphTo();
    }

//    public function attributes(): morphToMany
//    {
//        return $this->morphToMany(Attribute::class, 'attributable');
//    }

    public function attributeValues(): MorphToMany
    {
        return $this->morphToMany(AttributeValue::class, 'attribute_valuable');
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }
    // consider methods normalizeKey, buildKey, syncFilters
}
