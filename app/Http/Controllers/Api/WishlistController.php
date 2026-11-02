<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\Catalog\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()
            ->wishlist()
            ->active()
            ->with(['slug', 'brand', 'discount', 'media', 'promotions' => fn ($query) => $query->active()])
            ->paginate(12)
            ->withQueryString();

        return ProductListResource::collection($products);
    }

    public function store(Request $request, Product $product)
    {
        $request->user()->wishlist()->syncWithoutDetaching($product);

        return response()->noContent();
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->wishlist()->detach($product);

        return response()->noContent();
    }
}
