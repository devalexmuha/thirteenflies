<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class SeoMeta extends Model
{
    /** @use HasFactory<\Database\Factories\SeoMetaFactory> */
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['meta_title', 'meta_description', 'alt', 'h1', 'seo_text_top', 'seo_text_bottom', 'schema'];


    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
