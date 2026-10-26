<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * The promotion a product sells under. Comes from Product::bestPromotion(), which adds the "price" attribute.
 */
class ProductPromotionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'rate' => $this->discount_rate,
            'promotion_price' => $this->promotion_price,
        ];
    }
}
