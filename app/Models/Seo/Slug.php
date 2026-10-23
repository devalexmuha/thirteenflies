<?php

namespace App\Models\Seo;

use Database\Factories\Seo\SlugFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Slug extends Model
{
    /** @use HasFactory<SlugFactory> */
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
