<?php

namespace App\Models\Content;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSeoMeta;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Translatable;
use Database\Factories\Content\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, HasMedia, HasSeoMeta, HasSlug, Translatable;

    public array $translatable = ['name', 'excerpt', 'content'];

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'price_from' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
