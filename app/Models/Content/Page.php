<?php

namespace App\Models\Content;

use App\Enums\PageTemplate;
use App\Models\Traits\HasActiveScope;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Content\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasActiveScope, HasFactory, HasMedia, HasSeoMeta, HasSlug, Translatable;

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
