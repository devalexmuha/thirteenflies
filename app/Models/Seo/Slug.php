<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Slug extends Model
{
    /** @use HasFactory<\Database\Factories\SlugFactory> */
    use HasFactory, HasTranslations;

    public $timestamps = false;

    public array $translatable = ['slug'];

    protected $guarded = [];

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}

// how to write translations of the slug?
