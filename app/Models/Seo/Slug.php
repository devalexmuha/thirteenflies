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
    use HasFactory, Translatable;

    public $timestamps = false;

    public array $translatable = ['slug'];

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (Slug $slug): void {
            foreach ($slug->getTranslations('slug') as $locale => $value) {
                $slug->setTranslation('slug', $locale, Str::slug($value, '-', $locale));
            }
        });
    }

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
