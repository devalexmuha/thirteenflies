<?php

namespace App\Models\Seo;

use App\Models\Traits\Translatable;
use App\Support\ContentLocale;
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
            $seoMeta->robots ??= 'index, follow';

            $owner = $seoMeta->seoable;

            $names = $owner->isTranslatableAttribute('name')
                ? $owner->getTranslations('name')
                : [ContentLocale::get() => $owner->name];

            foreach ($names as $locale => $name) {
                if (blank($seoMeta->getTranslation('meta_title', $locale, false))) {
                    $seoMeta->setTranslation('meta_title', $locale, $name);
                }
            }
        });
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
