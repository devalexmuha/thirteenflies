<?php

namespace App\Services;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Catalog\Promotion;
use App\Models\Content\Article;
use App\Models\Content\Author;
use App\Models\Content\Page;
use App\Models\Content\Service;
use App\Models\Traits\HasScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Lists every sitemap section and the pages of each one. The client (Next.js) turns this data into sitemap.xml,
 * because only the client knows the public URLs. Only active records are listed.
 */
class SitemapGenerator
{
    public const int PER_PAGE = 1000;

    /**
     * Section name => model class.
     *
     * @var array<string, class-string<Model>>
     */
    public const array SECTIONS = [
        'products' => Product::class,
        'categories' => Category::class,
        'brands' => Brand::class,
        'discounts' => Discount::class,
        'promotions' => Promotion::class,
        'articles' => Article::class,
        'authors' => Author::class,
        'services' => Service::class,
        'pages' => Page::class,
    ];

    /**
     * @return array<int, array{name: string, total: int, last_page: int}>
     */
    public function index(): array
    {
        return collect(self::SECTIONS)
            ->map(fn (string $model, string $name) => [
                'name' => $name,
                'total' => $total = $this->query($model)->count(),
                'last_page' => max(1, (int) ceil($total / self::PER_PAGE)),
            ])
            ->values()
            ->all();
    }

    /**
     * One page of a section: slugs of every locale (the client builds the URLs) and the last change date.
     */
    public function show(string $name): LengthAwarePaginator
    {
        return $this->query(self::SECTIONS[$name])
            ->with('slugs')
            ->orderBy('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString()
            ->through(fn (Model $model) => [
                'slugs' => $model->slugs->pluck('slug', 'locale'),
                'updated_at' => $model->updated_at,
            ]);
    }

    /**
     * @param  class-string<Model>  $model
     * @return Builder<Model>
     */
    protected function query(string $model): Builder
    {
        return $model::query()
            ->when(in_array(HasScope::class, class_uses_recursive($model)), fn (Builder $query) => $query->active());
    }
}
