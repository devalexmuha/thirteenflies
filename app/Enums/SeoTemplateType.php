<?php

namespace App\Enums;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Catalog\Promotion;
use App\Models\Content\Article;
use App\Models\Content\Author;
use App\Models\Content\Page;
use App\Models\Content\Service;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Model;

enum SeoTemplateType: string implements HasLabel
{
    // Catalog
    case Category = 'category'; // {name}
    case Brand = 'brand'; // {name}
    case Promotion = 'promotion'; // {name}
    case Product = 'product'; // {name} {price}
    case Discount = 'discount'; // {name}

    // Content
    case Page = 'page'; // {name}
    case Article = 'article'; // {name}
    case Service = 'service'; // {name}
    case Author = 'author'; // {name}

    public function getLabel(): string
    {
        return match ($this) {
            self::Category => 'Category',
            self::Brand => 'Brand',
            self::Promotion => 'Promotion',
            self::Product => 'Product',
            self::Discount => 'Discount',
            self::Page => 'Page',
            self::Article => 'Article',
            self::Service => 'Service',
            self::Author => 'Author',
        };
    }

    public function model(): string
    {
        return match ($this) {
            self::Category => Category::class,
            self::Brand => Brand::class,
            self::Promotion => Promotion::class,
            self::Product => Product::class,
            self::Discount => Discount::class,
            self::Page => Page::class,
            self::Article => Article::class,
            self::Service => Service::class,
            self::Author => Author::class,
        };
    }

    public static function forModel(Model $model): ?self
    {
        foreach (self::cases() as $case) {
            if ($model instanceof ($case->model())) {
                return $case;
            }
        }

        return null;
    }

    public function variables(): array
    {
        return match ($this) {
            self::Product => ['{name}', '{price}'],
            default => ['{name}'],
        };
    }
}
