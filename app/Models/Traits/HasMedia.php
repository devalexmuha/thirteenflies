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
                    ->withPivot('order', 'locale', 'image_type')
                    ->withPivotValue('locale', ContentLocale::get())
                    ->orderByPivot('order');
    }

    public function mainBanner(): MorphToMany
    {
        return $this->media()->withPivotValue('image_type', 'main_banner');
    }

    public function featuredImage(): MorphToMany
    {
        return $this->media()->withPivotValue('image_type', 'featured');
    }
}
