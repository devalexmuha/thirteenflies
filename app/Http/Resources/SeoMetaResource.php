<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'h1' => $this->h1,
            'seo_text_top' => $this->whenNotNull($this->seo_text_top),
            'seo_text_bottom' => $this->whenNotNull($this->seo_text_bottom),
            'canonical' => $this->canonical,
            'robots' => $this->robots,
            'schema' => $this->schema,
        ];
    }
}
