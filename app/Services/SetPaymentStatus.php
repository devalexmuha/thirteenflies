<?php

namespace App\Services;

use App\Models\Sales\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

/**
 * Class SetPaymentStatus.
 */
class SetPaymentStatus
{

    public function process(Request $request): void
    {
        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret'),
            );
        } catch (SignatureVerificationException|UnexpectedValueException $e) {
            Log::warning('Stripe webhook rejected', ['error' => $e->getMessage()]);

            abort(400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $paymentStatus = $session->payment_status === 'paid' ? 'paid' : 'unpaid';

            Payment::query()->where('checkout_session_id', $session->id)->firstOrFail()->update(['status' => $paymentStatus]);

        }
    }

}
