<?php

namespace App\Models\Seo;

use App\Models\Catalog\Category;
use App\Models\Traits\Translatable;
use Database\Factories\Seo\ProductMetaTemplateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMetaTemplate extends Model
{
    /** @use HasFactory<ProductMetaTemplateFactory> */
    use HasFactory, Translatable;

    protected $guarded = [];

    protected $table = 'seo_product_meta_templates';

    public array $translatable = ['meta_title', 'meta_description'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
