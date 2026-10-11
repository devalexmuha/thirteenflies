<?php

namespace App\Models\Traits;

use App\Models\Filters\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAttributes
{
    public function filterAttributes(): morphToMany
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }
}
