<?php

namespace App\Models\Filters;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeFactory> */
    use HasFactory, Translatable;

    public array $translatable = ['name'];

    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Attribute $attribute): void {
                $attribute->slug = Str::slug($attribute->getTranslation('name', 'en', false));
        });
    }

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'attributable');
    }

    public function brands(): MorphToMany
    {
        return $this->morphedByMany(Brand::class, 'attributable');
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
