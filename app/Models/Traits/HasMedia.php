<?php

namespace App\Models\Traits;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasMedia
{
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable')
                    ->withPivot('order')
                    ->orderByPivot('order');
    }
}
