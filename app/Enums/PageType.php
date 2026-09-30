<?php

namespace App\Enums;

enum PageType: string
{
    case Page = 'page';
    case Category = 'category';
    case Brand = 'brand';
    case Product = 'product';
    case FilterPage = 'filter_page';
    case Service = 'service';
    case Article = 'article';
    case Author = 'author';

    public function label(): string
    {
        return match ($this) {
            self::Page => 'Pages',
            self::Category => 'Categories',
            self::Brand => 'Brands',
            self::Product => 'Products',
            self::FilterPage => 'Seo filter pages',
            self::Service => 'Services',
            self::Article => 'Articles',
            self::Author => 'Authors',
        };
    }

    public function variables(): array
    {
        return match ($this) {
            self::Product => ['{name}', '{brand}', '{category}', '{price}', '{sku}', '{url}', '{image}'],
            self::Category => ['{name}', '{parent}', '{count}', '{min_price}', '{url}'],
            self::Brand => ['{name}', '{count}', '{url}', '{logo}'],
            self::FilterPage => ['{name}', '{category}', '{count}', '{min_price}', '{url}'],
            self::Article => ['{title}', '{author}', '{date}', '{url}', '{image}'],
            self::Service => ['{title}', '{price_from}', '{url}'],
            self::Author => ['{name}', '{position}', '{url}'],
            self::Page => ['{title}', '{url}'],
        };
    }


}
