<?php

namespace App\Models\Traits;

use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSlug
{
    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable')
                    ->withAttributes(['locale' => ContentLocale::get()]);
    }

    public function slugs(): MorphMany
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }

    public static function bootHasSlug(): void
    {
        static::deleting(function ($model): void {
            $model->slugs()->delete();
        });
    }
}
