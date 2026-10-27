<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * For models with an is_active column: ->active() keeps only the records switched on in the admin panel.
 */
trait HasActiveScope
{
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
