<?php

namespace App\Notifications;

use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Number;

class OrderCreated extends Notification
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
            ->subject("Thank you for your order {$this->order->number}")
            ->greeting('Thank you for your order!')
            ->line("We have received your order **{$this->order->number}** and we are already getting it ready.")
            ->line('Order total: **'.Number::currency($this->order->total / 100, 'USD').'**')
            ->line('We will email you again as soon as its status changes.')
            ->line('Thank you for choosing us, we really appreciate it!');
    }
}
