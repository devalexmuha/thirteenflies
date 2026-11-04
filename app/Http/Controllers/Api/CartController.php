<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Catalog\Product;
use App\Models\Sales\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Request $request)
    {
        return $this->cartResource($request);
    }

    public function store(Request $request, Product $product)
    {
        abort_unless($product->is_active, 404, 'Product not found.');
        abort_unless($product->in_stock, 422, 'Product is out of stock.');

        $cart = $request->user()->cart()->firstOrCreate();

        abort_if($cart->items()->where('product_id', $product->id)->exists(), 409, 'Product is already in the cart.');

        $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

        return $this->cartResource($request)->response()->setStatusCode(201);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate(
            ['quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock_qty]],
            ['quantity.max' => 'Only :max in stock.'],
        );

        $this->cartItem($request, $product)->update($validated);

        return $this->cartResource($request);
    }

    public function destroy(Request $request, Product $product)
    {
        $this->cartItem($request, $product)->delete();

        return $this->cartResource($request);
    }

    public function clear(Request $request)
    {
        $request->user()->cart?->items()->delete();

        return response()->noContent();
    }

    private function cartItem(Request $request, Product $product): CartItem
    {
        return $request->user()->cart()->firstOrFail()->items()->where('product_id', $product->id)->firstOrFail();
    }

    private function cartResource(Request $request): CartResource
    {
        $cart = $request->user()->cart()
            ->with([
                'items.product.slug',
                'items.product.brand',
                'items.product.discount',
                'items.product.media',
                'items.product.promotions' => fn ($query) => $query->active(),
            ])
            ->firstOrNew();

        return CartResource::make($cart);
    }
}
