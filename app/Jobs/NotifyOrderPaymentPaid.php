<?php

namespace App\Jobs;

use App\Models\Sales\Order;
use App\Notifications\OrderGotPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyOrderPaymentPaid implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Order $order) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->order->user->notify(new OrderGotPaid($this->order));
    }
}
