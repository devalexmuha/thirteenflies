<?php

namespace App\Models\SEO;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProductMetaTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\PoductMetaTemplateFactory> */
    use HasFactory, HasTranslations;

    protected $guarded = [];

    protected $table = 'seo_poduct_meta_templates';

    public array $translatable = ['meta_title', 'meta_description'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
