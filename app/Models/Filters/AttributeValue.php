<?php

namespace App\Models\Filters;

use App\Models\Catalog\Product;
use App\Models\Traits\Translatable;
use Database\Factories\Filters\AttributeValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    /** @use HasFactory<AttributeValueFactory> */
    use HasFactory, Translatable;

    public array $translatable = ['value'];

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (AttributeValue $attributeValue): void {
            $names = array_filter($attributeValue->getTranslations('value'));
            $locale = isset($names['en']) ? 'en' : array_key_first($names);

            $attributeValue->slug = Str::slug($names[$locale], '-', $locale);
        });
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'attribute_valuable');
    }

    public function filterPages(): MorphToMany
    {
        return $this->morphedByMany(FilterPage::class, 'attribute_valuable');
    }
}
