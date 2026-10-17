<?php

namespace App\Models\Content;

use App\Enums\ContentStatus;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, Translatable, HasSeoMeta, HasSlug, HasMedia;

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
