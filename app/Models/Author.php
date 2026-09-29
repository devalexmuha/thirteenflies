<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory, HasTranslations;

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
