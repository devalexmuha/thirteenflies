<?php

use App\Enums\OrderStatus;
use App\Models\Sales\Order;
use App\Notifications\OrderChanged;
use App\Notifications\OrderCreated;
use App\Services\OrderCreationNotificator;
use App\Services\OrderStatusNotificator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('emails the customer when an order is created', function () {
    Notification::fake();
    $order = Order::factory()->create(['total' => 2000]);

    (new OrderCreationNotificator($order))->notify();

    Notification::assertSentTo($order->user, OrderCreated::class, function (OrderCreated $notification) use ($order) {
        $mail = $notification->toMail($order->user);

        return str_contains($mail->subject, $order->number)
            && in_array('Order total: **$20.00**', $mail->introLines);
    });
});

it('emails the customer the current status when an order changes', function () {
    Notification::fake();
    $order = Order::factory()->create(['status' => OrderStatus::Delivery]);

    (new OrderStatusNotificator($order))->notify();

    Notification::assertSentTo($order->user, OrderChanged::class, function (OrderChanged $notification) use ($order) {
        return in_array('Current status: **Delivery**', $notification->toMail($order->user)->introLines);
    });
});
