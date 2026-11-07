<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews()->latest()->paginate(12)->withQueryString());
    }

    public function store(ReviewRequest $request, Product $product)
    {
        Gate::authorize('create', [Review::class, $product]);

        abort_if($request->user()->reviews()->where('product_id', $product->id)->exists(), 409, 'You have already reviewed this product.');

        $review = $request->user()->reviews()->create([
            ...$request->validated(),
            'product_id' => $product->id,
            'locale' => app()->getLocale(),
        ]);

        return ReviewResource::make($review)->response()->setStatusCode(201);
    }

    public function update(ReviewRequest $request, Product $product)
    {
        $review = $request->user()->reviews()->where('product_id', $product->id)->firstOrFail();

        Gate::authorize('update', $review);

        $review->update($request->validated());

        return ReviewResource::make($review);
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->reviews()->where('product_id', $product->id)->firstOrFail()->delete();

        return response()->noContent();
    }
}
