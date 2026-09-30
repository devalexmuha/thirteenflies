<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory, HasTranslations;

    protected $table = 'media';
    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleted(fn (Media $media) => Storage::disk($media->disk)->delete($media->path));
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
