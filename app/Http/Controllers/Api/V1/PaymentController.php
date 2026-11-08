<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Sales\Order;
use App\Services\CreatePaymentUrl;
use App\Services\GetPaymentStatus;
use App\Services\SetPaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order, CreatePaymentUrl $createPaymentUrl): JsonResource
    {
        $order = $request->user()->orders()->findOrFail($order->id);
        $order->load('items.product');

        abort_if($order->payment_status === PaymentStatus::Paid, 409, 'This order has already been paid.');

        $stripeSessionUrl = $createPaymentUrl->make($order);

        return JsonResource::make(['payment_url' => $stripeSessionUrl]);
    }

    public function status(Request $request, GetPaymentStatus $getPaymentStatus): JsonResource
    {
        $validated = $request->validate([
            'session_id' => ['required', 'string', Rule::exists('payments', 'checkout_session_id')->whereIn('order_id', $request->user()->orders()->pluck('id'))],
        ]);

        $paymentStatus = $getPaymentStatus->get($validated['session_id']);

        return JsonResource::make(['payment_status' => $paymentStatus]);
    }

    public function webhook(Request $request, SetPaymentStatus $setPaymentStatus): Response
    {
        $setPaymentStatus->process($request);

        return response()->noContent();
    }
}
