<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Review $review) {
            $review->author_name = $review->user->profile->first_name;
        });

        static::saved(fn (Review $review) => $review->product->refreshRating());
        static::deleted(fn (Review $review) => $review->product->refreshRating());
    }



}
