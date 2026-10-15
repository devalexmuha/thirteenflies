<?php

namespace App\Models\Traits;

use App\Support\ContentLocale;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasMedia
{
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable')
                    ->withPivot('order', 'locale')
                    ->withPivotValue('locale', ContentLocale::get())
                    ->orderByPivot('order');
    }
}
