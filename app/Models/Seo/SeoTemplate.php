<?php

namespace App\Models\Seo;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SeoTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\SeoTemplateFactory> */
    use HasFactory, Translatable;

    protected $guarded = [];

    public array $translatable = ['meta_title', 'meta_description', 'h1', 'alt', 'schema'];
}
