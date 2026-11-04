<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Account\Address;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        return OrderResource::collection($request->user()->orders()->latest()->paginate(10));
    }

    public function show(Request $request, Order $order)
    {
        $this->ensureOwnedBy($request, $order);

        return OrderResource::make($order->load('items'));
    }

    /**
     * Turns the user's cart into an order: prices are fixed at this moment, stock is reduced, the cart is emptied.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_id' => ['required', Rule::exists('addresses', 'id')->where('user_id', $request->user()->id)],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $request->user()->cart()->with('items')->first();

        abort_if($cart === null || $cart->items->isEmpty(), 422, 'Cart is empty.');

        $order = DB::transaction(function () use ($request, $validated, $cart) {
            $products = Product::query()
                ->whereKey($cart->items->pluck('product_id'))
                ->with(['promotions' => fn ($query) => $query->active()])
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $lines = $cart->items->map(function ($item) use ($products) {
                $product = $products->get($item->product_id);

                abort_unless($product?->is_active, 422, 'A product in the cart is no longer available.');
                abort_if($product->stock_qty < $item->quantity, 422, "Not enough stock for {$product->sku}.");

                $unitPrice = (int) round(($product->bestPromotion()?->promotion_price ?? $product->discount_price ?? $product->price) * 100);

                return [
                    'product' => $product,
                    'item' => ['product_id' => $product->id, 'sku' => $product->sku, 'price' => $unitPrice, 'quantity' => $item->quantity, 'total' => $unitPrice * $item->quantity],
                ];
            });

            $subtotal = $lines->sum('item.total');

            $order = $request->user()->orders()->create([
                'email' => $request->user()->email,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'locale' => app()->getLocale(),
                'shipping_address' => Address::find($validated['address_id'])->only([
                    'full_name', 'phone', 'country', 'state', 'city', 'zip', 'address_line_1', 'address_line_2',
                ]),
                'customer_note' => $validated['customer_note'] ?? null,
            ]);

            $order->items()->createMany($lines->pluck('item'));
            $order->statusLogs()->create(['user_id' => $request->user()->id, 'status' => OrderStatus::Pending]);

            foreach ($lines as $line) {
                $line['product']->update(['stock_qty' => $line['product']->stock_qty - $line['item']['quantity']]);
            }

            $cart->items()->delete();

            return $order;
        });

        return OrderResource::make($order->refresh()->load('items'))->response()->setStatusCode(201);
    }

    /**
     * Cancels the order: only while it is pending and not paid. Returns the stock.
     */
    public function update(Request $request, Order $order)
    {
        $this->ensureOwnedBy($request, $order);

        abort_unless(
            $order->status === OrderStatus::Pending && $order->payment_status === PaymentStatus::Unpaid,
            409,
            'This order can no longer be canceled.',
        );

        DB::transaction(function () use ($request, $order) {
            $order->update(['status' => OrderStatus::Canceled, 'canceled_at' => now()]);
            $order->statusLogs()->create([
                'user_id' => $request->user()->id,
                'from_status' => OrderStatus::Pending,
                'status' => OrderStatus::Canceled,
            ]);

            foreach ($order->items()->with('product')->get() as $item) {
                $item->product?->update(['stock_qty' => $item->product->stock_qty + $item->quantity]);
            }
        });

        return OrderResource::make($order->load('items'));
    }

    private function ensureOwnedBy(Request $request, Order $order): void
    {
        abort_unless($order->user_id === $request->user()->id, 404);
    }
}
