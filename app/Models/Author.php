<?php

namespace App\Models;

use App\Models\Traits\HasSeoMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory, HasTranslations, HasSeoMeta;

    public array $translatable = ['position', 'bio'];

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'socials' => 'array',
            'is_active' => 'boolean',
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
