<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListProductsRequest;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Models\Catalog\Category;
use App\Services\ProductListing;
use App\Services\SeoMetaResolver;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()
            ->active()
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
            'children' => fn ($query) => $query->active()->with('slug')->defaultOrder(),
            'ancestors' => fn ($query) => $query->with('slug')->defaultOrder(),
        ]);

        $category->setRelation('seoMeta', $seoMetaResolver->resolve($category));

        return CategoryResource::make($category);
    }

    /**
     * Listing of all products which belong to this category
     */
    public function products(Category $category, ListProductsRequest $listProductsRequest, ProductListing $productListing)
    {
        $products = $productListing->paginate($category, $listProductsRequest);

        return ProductListResource::collection($products);
    }
}

// build query resolver service
