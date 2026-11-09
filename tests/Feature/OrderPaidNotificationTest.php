<?php

use App\Enums\PaymentStatus;
use App\Models\Sales\Order;
use App\Notifications\OrderGotPaid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('emails the customer when the order payment status becomes paid', function () {
    Notification::fake();

    $order = Order::factory()->create(['total' => 2000, 'payment_status' => PaymentStatus::Unpaid]);

    $order->update(['payment_status' => PaymentStatus::Paid]);

    Notification::assertSentTo($order->user, OrderGotPaid::class, function (OrderGotPaid $notification) use ($order) {
        $mail = $notification->toMail($order->user);

        return $mail->subject === "Payment received for order {$order->number}"
            && collect($mail->introLines)->contains(fn ($line) => str_contains($line, '$20.00'));
    });
});
