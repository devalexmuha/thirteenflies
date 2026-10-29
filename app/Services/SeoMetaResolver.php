<?php

namespace App\Services;

use App\Enums\SeoTemplateType;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Seo\ProductMetaTemplate;
use App\Models\Seo\SeoMeta;
use App\Models\Seo\SeoTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SeoMetaResolver
{
    /** Fields filled from the template when the model's own SEO meta has no value. */
    private const TEMPLATED_FIELDS = ['meta_title', 'meta_description', 'h1'];

    /**
     * The model's SEO meta with every blank field filled from the SEO template of its type.
     * The returned instance is a copy and is never saved.
     */
    public function resolve(Model $model): SeoMeta
    {
        $meta = $model->seoMeta;
        $templates = $this->templatesFor($model);

        foreach (self::TEMPLATED_FIELDS as $field) {
            $text = $templates->pluck($field)->first(fn ($value) => filled($value));

            if (blank($meta->{$field}) && $text !== null) {
                $meta->{$field} = $this->replacePlaceholders($text, $model);
            }
        }

        return $meta;
    }

    /**
     * Templates in priority order: the product's category template first, then the general one.
     *
     * @return Collection<int, Model>
     */
    private function templatesFor(Model $model): Collection
    {
        $type = SeoTemplateType::forModel($model);

        return collect([
            $model instanceof Product ? $this->categoryTemplateFor($model) : null,
            $type === null ? null : SeoTemplate::where('page_type', $type)->first(),
        ])->filter();
    }

    /**
     * Nearest filled product template among the product's categories and their ancestors.
     * Deeper categories have a larger _lft, so they win over their parents.
     */
    private function categoryTemplateFor(Product $product): ?ProductMetaTemplate
    {
        $categoryIds = $product->categories
            ->flatMap(fn (Category $category) => Category::whereAncestorOf($category, true)->pluck('id'))
            ->unique();

        return ProductMetaTemplate::join('categories', 'categories.id', '=', 'seo_product_meta_templates.category_id')
            ->whereIn('seo_product_meta_templates.category_id', $categoryIds)
            ->orderByDesc('categories._lft')
            ->select('seo_product_meta_templates.*')
            ->get()
            ->first(fn (ProductMetaTemplate $template) => filled($template->meta_title) || filled($template->meta_description));
    }

    private function replacePlaceholders(string $text, Model $model): string
    {
        return strtr($text, [
            '{name}' => (string) $model->name,
            '{price}' => $model instanceof Product ? number_format($model->price, 2) : '',
        ]);
    }
}
