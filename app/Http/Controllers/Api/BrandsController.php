<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListProductsRequest;
use App\Http\Resources\BrandListResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\FilterListResource;
use App\Http\Resources\ProductListResource;
use App\Models\Catalog\Brand;
use App\Services\FilterListing;
use App\Services\ProductListing;
use App\Services\SeoMetaResolver;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()
            ->active()
            ->orderBy('name')
            ->with('slug')
            ->get();

        return BrandListResource::collection($brands);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand, SeoMetaResolver $seoMetaResolver)
    {
        $brand->load(['slug', 'slugs', 'seoMeta', 'media']);

        $brand->setRelation('seoMeta', $seoMetaResolver->resolve($brand));

        return BrandResource::make($brand);
    }

    /**
     * Listing of all products which belong to this brand
     */
    public function products(Brand $brand, ListProductsRequest $listProductsRequest, ProductListing $productListing)
    {
        $products = $productListing->paginate($brand, $listProductsRequest);

        return ProductListResource::collection($products);
    }

    /**
     * Listing of all filters which belong to this brand
     */
    public function filters(Brand $brand, FilterListing $filterListing)
    {
        return FilterListResource::make($filterListing->forModel($brand));
    }
}
