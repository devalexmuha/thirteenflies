<?php

namespace App\Services;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

/**
 * Class GetPaymentStatus.
 */
class GetPaymentStatus
{
    public function get(string $sessionId): string
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
        } catch (ApiErrorException $e) {
            report($e);
            abort(503, 'Payment status is temporarily unavailable.');
        }

        return $session->payment_status === 'paid' ? 'paid' : 'unpaid';
    }
}
