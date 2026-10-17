<?php

namespace App\Enums;

enum PageTemplate: string
{
    case Single = 'single';
    case Home = 'home';
    case BrandListing = 'brand_listing';
    case BlogListing = 'blog_listing';
    case ServiceListing = 'service_listing';
    case AuthorListing = 'author_listing';
}
