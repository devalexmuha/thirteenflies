<?php

namespace App\Models\Traits;

use App\Models\Seo\Slug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSlug
{
    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }

    public static function bootHasSlug(): void
    {
        static::deleting(function ($model): void {
            $model->slug()->delete();
        });
    }
}
