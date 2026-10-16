<?php

namespace App\Models\Seo;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Slug extends Model
{
    /** @use HasFactory<\Database\Factories\SlugFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (Slug $slug): void {
            $slug->slug = Str::slug($slug->slug, '-', $slug->locale);
        });
    }

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
