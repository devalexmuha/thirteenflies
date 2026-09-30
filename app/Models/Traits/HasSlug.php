<?php

namespace App\Models\Traits;

use App\Models\Seo\Slug;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasSlug
{
    public function slugs(): MorphMany
    {
        return $this->morphMany(Slug::class, 'sluggable');
    }
}
