<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Services\SeoMetaResolver;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with('slug')
            ->defaultOrder()
            ->get()
            ->toTree();

        return CategoryListResource::collection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, SeoMetaResolver $seoMetaResolver)
    {
        $category->load([
            'slug',
            'slugs',
            'seoMeta',
            'media',
            'children' => fn ($query) => $query->where('is_active', true)->with('slug')->defaultOrder(),
            'ancestors' => fn ($query) => $query->with('slug')->defaultOrder(),
        ]);

        $category->setRelation('seoMeta', $seoMetaResolver->resolve($category));

        return CategoryResource::make($category);
    }

    /**
     * Listing of all products which belong to this category
     */
    public function products(Category $category)
    {
        $products = Product::query()
            ->active()
            ->inCategoryTree($category)
            ->with(['slug', 'brand', 'discount', 'media', 'promotions' => fn ($query) => $query->active()])
            ->paginate(24);

        return ProductListResource::collection($products);
    }
}

// check scopeActive on promotion
// 'type' => $this->pivot?->image_type, hide on products
// check ProductPromotion resource
// build query resolver service
// build product endpoints
// build brand...
