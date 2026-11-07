<?php

namespace App\Models\Traits;

use App\Support\ContentLocale;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

trait HasMedia
{
    public static function bootHasMedia(): void
    {
        static::deleting(function ($model): void {
            $links = DB::table('mediables')
                ->where('mediable_type', $model::class)
                ->where('mediable_id', $model->id)->delete();
        });
    }

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
