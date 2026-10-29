<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder<static> active()
 */
trait HasScope
{
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
