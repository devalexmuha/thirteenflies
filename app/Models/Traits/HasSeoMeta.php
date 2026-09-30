<?php

namespace App\Models\Traits;

use App\Models\SeoMeta;
use App\Models\SeoTemplate;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeoMeta
{
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
