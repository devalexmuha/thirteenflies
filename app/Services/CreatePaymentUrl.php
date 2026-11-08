<?php

namespace App\Services;

use App\Models\Sales\Order;
use Stripe\StripeClient;

/**
 * Class CreatePaymentUrl.
 */
class CreatePaymentUrl
{
    public function make(Order $order)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($order->items as $orderItem) {
            $lineItems[] = [
                'quantity' => $orderItem->quantity,
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $orderItem->product->name,
                    ],
                    'unit_amount' => $orderItem->price,
                ],
            ];
        }

        $checkoutSession = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => config('services.stripe.success_url'),
            'cancel_url' => config('services.stripe.cancel_url'),
            'line_items' => $lineItems,
        ]);

        $order->payments()->create(
            [
                'amount' => $order->total,
                'currency' => $order->currency,
                'checkout_session_id' => $checkoutSession->id,
            ],
        );

        return $checkoutSession->url;
    }
}
