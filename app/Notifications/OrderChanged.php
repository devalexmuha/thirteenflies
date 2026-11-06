<?php

namespace App\Notifications;

use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class OrderChanged extends Notification
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
        $status = Str::headline($this->order->status->value);

        return (new MailMessage)
            ->subject("Your order {$this->order->number} has been updated")
            ->greeting('Your order has been updated')
            ->line("The status of your order **{$this->order->number}** has changed.")
            ->line("Current status: **{$status}**")
            ->line('Thank you for choosing us!');
    }
}
