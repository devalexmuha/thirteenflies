<?php

namespace App\Models\Seo;

use App\Models\Traits\HasScope;
use Database\Factories\Seo\RedirectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    /** @use HasFactory<RedirectFactory> */
    use HasFactory, HasScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'hits' => 'integer',
            'last_hit_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
