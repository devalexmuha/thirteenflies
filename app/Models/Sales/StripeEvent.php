<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class StripeEvent extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'processed_at' => 'datetime',
        ];
    }
}
