<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'price' => $this['price'],
            'brands' => $this['brands'],
            'attributes' => $this['attributes'],
            'filter_pages' => $this['filter_pages'],
        ];
    }
}
