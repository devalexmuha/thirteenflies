<?php

namespace App\Models\Content;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Content\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory, HasMedia, HasSeoMeta, HasSlug, Translatable;

    public array $translatable = ['position', 'bio', 'short_bio'];

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'socials' => 'array',
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
