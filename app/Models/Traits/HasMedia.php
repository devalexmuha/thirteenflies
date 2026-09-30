<?php

namespace App\Models\Traits;

use App\Models\Assets\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public static function bootHasMedia(): void
    {
        static::deleting(fn ($model) => $model->media()->get()->each->delete());
    }
}
