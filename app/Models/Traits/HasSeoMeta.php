<?php

namespace App\Models\Traits;

use App\Models\Seo\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeoMeta
{
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public static function bootHasSeoMeta(): void
    {
        static::deleting(fn ($model) => $model->seoMeta()->delete());
    }
}
