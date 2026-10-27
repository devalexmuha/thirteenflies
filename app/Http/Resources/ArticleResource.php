<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'slug' => SlugResource::make($this->whenLoaded('slug')),
            'slugs' => SlugResource::collection($this->whenLoaded('slugs')),
            'author' => AuthorListResource::make($this->whenLoaded('author')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'seo' => SeoMetaResource::make($this->whenLoaded('seoMeta')),
        ];
    }
}
