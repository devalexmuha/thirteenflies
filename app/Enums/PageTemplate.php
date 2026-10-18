<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PageTemplate: string implements HasLabel
{
    case Single = 'single';
    case Home = 'home';
    case BrandListing = 'brand_listing';
    case BlogListing = 'blog_listing';
    case ServiceListing = 'service_listing';
    case AuthorListing = 'author_listing';

    public function getLabel(): string
    {
        return match ($this) {
            self::Single => 'Single page',
            self::Home => 'Home page',
            self::BrandListing => 'Brands listing',
            self::BlogListing => 'Blog listing',
            self::ServiceListing => 'Services listing',
            self::AuthorListing => 'Authors listing',
        };
    }

    public function slug(): ?string
    {
        return match ($this) {
            self::Single => null,
            self::Home => 'main',
            self::BrandListing => 'brands',
            self::BlogListing => 'blog',
            self::ServiceListing => 'services',
            self::AuthorListing => 'authors',
        };
    }

    public static function fromState(mixed $state): ?self
    {
        return $state instanceof self ? $state : self::tryFrom((string) $state);
    }
}
