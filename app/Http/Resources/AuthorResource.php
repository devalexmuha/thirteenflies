<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'short_bio' => $this->short_bio,
            'bio' => $this->bio,
            'socials' => $this->socials,
            'slug' => SlugResource::make($this->whenLoaded('slug')),
            'slugs' => SlugResource::collection($this->whenLoaded('slugs')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'seo' => SeoMetaResource::make($this->whenLoaded('seoMeta')),
        ];
    }
}
