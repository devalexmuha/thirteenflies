<?php

namespace App\Models\Sales;

use App\Enums\PaymentStatus;
use Database\Factories\Sales\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::updated(function (Payment $payment): void {
            if ($payment->status === PaymentStatus::Paid) {
                $payment->order->update([
                    'payment_status' => PaymentStatus::Paid,
                ]);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status'  => PaymentStatus::class,
            'payload' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
