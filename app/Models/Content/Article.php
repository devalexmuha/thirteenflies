<?php

namespace App\Models\Content;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasScope;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Content\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory, HasMedia, HasScope, HasSeoMeta, HasSlug, Translatable;

    public array $translatable = ['name', 'excerpt', 'content'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected $guarded = [];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
