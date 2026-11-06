<?php

namespace App\Jobs;

use App\Models\Sales\Order;
use App\Notifications\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyOrderCreation implements ShouldQueue
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
        $this->order->user->notify(new OrderCreated($this->order));
    }
}
