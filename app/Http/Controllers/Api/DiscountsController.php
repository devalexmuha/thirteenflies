<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListProductsRequest;
use App\Http\Resources\DiscountListResource;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\ProductListResource;
use App\Models\Catalog\Discount;
use App\Services\ProductListing;
use App\Services\SeoMetaResolver;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::query()
            ->with('slug')
            ->get();

        return DiscountListResource::collection($discounts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount, SeoMetaResolver $seoMetaResolver)
    {
        $discount->load(['slug', 'slugs', 'seoMeta', 'media']);

        $discount->setRelation('seoMeta', $seoMetaResolver->resolve($discount));

        return DiscountResource::make($discount);
    }

    /**
     * Listing of all products which belong to this discount
     */
    public function products(Discount $discount, ListProductsRequest $listProductsRequest, ProductListing $productListing)
    {
        $products = $productListing->paginate($discount, $listProductsRequest);

        return ProductListResource::collection($products);
    }
}
