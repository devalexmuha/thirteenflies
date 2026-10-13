<?php

namespace App\Models\Filters;

use App\Models\Catalog\Product;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeValueFactory> */
    use HasFactory, Translatable;

    public array $translatable = ['value'];

    protected $guarded = [];

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
