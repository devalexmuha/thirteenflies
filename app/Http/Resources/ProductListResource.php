<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Product card for listings. Expects the controller to load: slug, brand, discount, media.
 */
class ProductListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $promotion = $this->bestPromotion();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => SlugResource::make($this->whenLoaded('slug')),
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'promotion' => $promotion ? ProductPromotionResource::make($promotion) : null,
            'is_discounted' => (bool) $this->is_discounted,
            'in_stock' => (bool) $this->in_stock,
            'rating' => $this->avr_rating,
            'brand' => $this->brand?->name,
            'discount' => $this->discount?->name,
            'images' => $this->media->isEmpty() ? null : MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
