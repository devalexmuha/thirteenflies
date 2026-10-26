<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full product for the product page. Expects the controller to load: slug, slugs, seoMeta, brand.slug,
 * discount, media, categories.slug, attributeValues.attribute, videos, relatedProducts (with the list relations).
 */
class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Read the relation with getRelation(): $this->slug returns Product's translatable "slug" attribute (null)
        $slug = $this->resource->getRelation('slug');

        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $slug ? SlugResource::make($slug) : null,
            'slugs' => SlugResource::collection($this->slugs),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'promotion_price' => $this->promotion_price ?? null, // set later by the price service
            'is_discounted' => (bool) $this->is_discounted,
            'in_stock' => (bool) $this->in_stock,
            'rating' => $this->avr_rating,
            'brand' => $this->brand ? [
                'name' => $this->brand->name,
                'slug' => SlugResource::make($this->brand->slug),
            ] : null,
            'discount' => $this->discount?->name,
            'categories' => CategoryListResource::collection($this->categories),
            'media' => MediaResource::collection($this->media),
            'attributes' => $this->attributeValues->map(fn ($value) => [
                'name' => $value->attribute->name,
                'value' => $value->value,
            ]),
            'videos' => $this->videos->pluck('video_link'),
            'related_products' => ProductListResource::collection($this->whenLoaded('relatedProducts')),
            'seo' => SeoMetaResource::make($this->seoMeta),
        ];
    }
}
