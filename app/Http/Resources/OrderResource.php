<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Money is stored in cents and exposed in currency units, like the product prices.
 */
class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'subtotal' => $this->subtotal / 100,
            'shipping_total' => $this->shipping_total / 100,
            'tax_total' => $this->tax_total / 100,
            'total' => $this->total / 100,
            'currency' => $this->currency,
            'shipping_address' => $this->shipping_address,
            'customer_note' => $this->customer_note,
            'created_at' => $this->created_at,
            'paid_at' => $this->paid_at,
            'canceled_at' => $this->canceled_at,
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'sku' => $item->sku,
                'price' => $item->price / 100,
                'quantity' => $item->quantity,
                'total' => $item->total / 100,
            ])),
        ];
    }
}
