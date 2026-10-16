<?php

namespace App\Models\Seo;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    /** @use HasFactory<\Database\Factories\SeoMetaFactory> */
    use HasFactory, Translatable;

    protected $guarded = [];

    public array $translatable = [
        'meta_title', 'meta_description', 'alt', 'h1', 'seo_text_top', 'seo_text_bottom', 'schema'
    ];

    protected static function booted(): void
    {
        static::saving(function (SeoMeta $seoMeta): void {
            $names = $seoMeta->seoable->getTranslations('name');

            foreach ($names as $locale => $name) {
                foreach (['h1', 'meta_title'] as $field) {
                    if (blank($seoMeta->getTranslation($field, $locale, false))) {
                        $seoMeta->setTranslation($field, $locale, $name);
                    }
                }
            }

            $seoMeta->robots ??= 'index, follow';
        });
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
