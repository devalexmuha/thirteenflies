<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListProductsRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Catalog\Product;
use App\Services\ProductListing;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListProductsRequest $listProductsRequest, ProductListing $productListing)
    {
        $products = $productListing->paginate(null, $listProductsRequest);

        return ProductListResource::collection($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'slug',
            'slugs',
            'seoMeta',
            'brand.slug',
            'discount',
            'media',
            'categories.slug',
            'attributeValues.attribute',
            'videos',
            'promotions' => fn ($query) => $query->active(),
            'relatedProducts' => fn ($query) => $query
                ->active()
                ->with(['slug', 'brand', 'discount', 'media', 'promotions' => fn ($query) => $query->active()]),
        ]);

        return ProductResource::make($product);
    }
}
