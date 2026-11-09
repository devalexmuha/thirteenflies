<?php

namespace App\Notifications;

use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Number;

class OrderGotPaid extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Payment received for order {$this->order->number}")
            ->greeting('Congratulations, your order has been paid!')
            ->line("We have received your payment for order **{$this->order->number}**.")
            ->line('Amount paid: **'.Number::currency($this->order->total / 100, 'USD').'**')
            ->line('We are preparing your order now and will email you when its status changes.')
            ->line('Thank you for choosing us, we really appreciate it!');
    }
}
