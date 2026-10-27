<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full product for the product page. Expects the controller to load: slug, slugs, seoMeta, brand.slug, discount,
 * media, categories.slug, attributeValues.attribute, videos, promotions and relatedProducts (with the list relations).
 */
class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $promotion = $this->bestPromotion();

        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => SlugResource::make($this->whenLoaded('slug')),
            'slugs' => SlugResource::collection($this->whenLoaded('slugs')),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'promotion' => $promotion ? ProductPromotionResource::make($promotion) : null,
            'is_discounted' => (bool) $this->is_discounted,
            'in_stock' => (bool) $this->in_stock,
            'rating' => $this->avr_rating,
            'brand' => BrandListResource::make($this->whenLoaded('brand')),
            'discount' => $this->whenLoaded('discount', fn () => $this->discount?->name),
            'categories' => CategoryListResource::collection($this->whenLoaded('categories')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'attributes' => $this->whenLoaded('attributeValues', fn () => $this->attributeValues->map(fn ($value) => [
                'name' => $value->attribute->name,
                'value' => $value->value,
            ])),
            'videos' => $this->whenLoaded('videos', fn () => $this->videos->pluck('video_link')),
            'related_products' => ProductListResource::collection($this->whenLoaded('relatedProducts')),
            'seo' => SeoMetaResource::make($this->whenLoaded('seoMeta')),
        ];
    }
}
