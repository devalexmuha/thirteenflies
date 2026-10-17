<?php

namespace App\Models\Content;

use App\Enums\PageTemplate;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory, Translatable, HasSeoMeta, HasSlug, HasMedia;

    public array $translatable = ['name', 'content'];

    protected $guarded = [];


    protected function casts(): array
    {
        return [
            'template' => PageTemplate::class,
            'is_active' => 'boolean',
        ];
    }
}
