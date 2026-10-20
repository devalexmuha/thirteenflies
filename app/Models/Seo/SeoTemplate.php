<?php

namespace App\Models\Seo;

use App\Enums\SeoTemplateType;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\SeoTemplateFactory> */
    use HasFactory, Translatable;

    protected $guarded = [];

    public array $translatable = ['meta_title', 'meta_description', 'h1', 'alt', 'schema'];

    protected function casts(): array
    {
        return [
            'page_type' => SeoTemplateType::class,
        ];
    }
}
