<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RedirectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'from' => $this->when($request->routeIs('redirects.index'), $this->from_path),
            'to' => $this->to_path,
            'status_code' => $this->status_code,
        ];
    }
}
