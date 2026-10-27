<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListProductsRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\PromotionListResource;
use App\Http\Resources\PromotionResource;
use App\Models\Catalog\Promotion;
use App\Services\ProductListing;
use App\Services\SeoMetaResolver;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::query()
            ->active()
            ->with('slug')
            ->get();

        return PromotionListResource::collection($promotions);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion, SeoMetaResolver $seoMetaResolver)
    {
        $promotion->load(['slug', 'slugs', 'seoMeta', 'media']);

        $promotion->setRelation('seoMeta', $seoMetaResolver->resolve($promotion));

        return PromotionResource::make($promotion);
    }

    /**
     * Listing of all products which belong to this promotion
     */
    public function products(Promotion $promotion, ListProductsRequest $listProductsRequest, ProductListing $productListing)
    {
        $products = $productListing->paginate($promotion, $listProductsRequest);

        return ProductListResource::collection($products);
    }
}
