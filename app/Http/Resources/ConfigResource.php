<?php

namespace App\Http\Resources;

use App\Enums\Locale;
use App\Settings\ContactSettings;
use App\Settings\MenuSettings;
use Awcodes\Curator\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @property-read ContactSettings $contacts
 * @property-read MenuSettings $menus
 */
class ConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'locale' => app()->getLocale(),
            'locales' => collect(Locale::cases())->map(fn (Locale $locale): array => [
                'code' => $locale->value,
                'label' => $locale->label(),
                'flag' => $locale->flag(),
            ])->all(),
            'contacts' => [
                'phone' => $this->contacts->phone,
                'email' => $this->contacts->email,
                'addresses' => collect($this->contacts->addresses)->map(fn (array $address): array => [
                    'address' => $address['address'][app()->getLocale()] ?? [],
                    'working_hours' => $address['working_hours'] ?? null,
                    'map_link' => $address['map_link'] ?? null,
                    'latitude' => $address['latitude'] ?? null,
                    'longitude' => $address['longitude'] ?? null,
                ])->all(),
                'socials' => collect($this->contacts->socials)->map(fn (array $social): array => [
                    'link' => $social['link'] ?? null,
                    'icon' => Media::find(Arr::first(Arr::wrap($social['image'] ?? null)))?->url,
                ])->all(),
            ],
        ];
    }
}
