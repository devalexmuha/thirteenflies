<?php

namespace Database\Seeders;

use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Every user gets one to three orders shipped to their address, each with one to three random active products.
     * Run it after the users, addresses and products are seeded.
     */
    public function run(): void
    {
        $products = Product::active()->get();

        User::with('addresses')->get()->each(function (User $user) use ($products): void {
            $address = $user->addresses->first()->only([
                'full_name', 'phone', 'country', 'state', 'city', 'zip', 'address_line_1', 'address_line_2',
            ]);

            foreach (range(1, fake()->numberBetween(1, 3)) as $ignored) {
                $items = $products->random(min(fake()->numberBetween(1, 3), $products->count()))
                    ->map(function (Product $product): array {
                        $price = (int) round(($product->discount_price ?? $product->price) * 100);
                        $quantity = fake()->numberBetween(1, 3);

                        return [
                            'product_id' => $product->id,
                            'sku' => $product->sku,
                            'price' => $price,
                            'quantity' => $quantity,
                            'total' => $price * $quantity,
                        ];
                    });

                $order = Order::factory()->for($user)->create([
                    'email' => $user->email,
                    'subtotal' => $items->sum('total'),
                    'total' => $items->sum('total'),
                    'shipping_address' => $address,
                ]);

                $order->items()->createMany($items);
            }
        });
    }
}
