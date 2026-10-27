<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleListResource extends JsonResource
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
            'published_at' => $this->published_at,
            'slug' => SlugResource::make($this->whenLoaded('slug')),
            'author' => AuthorListResource::make($this->whenLoaded('author')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
