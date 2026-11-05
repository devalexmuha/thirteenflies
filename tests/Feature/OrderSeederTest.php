<?php

use App\Models\Account\User;
use App\Models\Catalog\Product;
use Database\Seeders\AddressSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gives every user one address and one to three orders with items', function () {
    User::factory()->count(5)->create();
    Product::factory()->count(4)->create(['name' => 'Guitar', 'stock_qty' => 5, 'is_active' => true]);

    $this->seed([AddressSeeder::class, OrderSeeder::class]);

    User::withCount(['addresses', 'orders'])->get()->each(function (User $user) {
        expect($user->addresses_count)->toBe(1)
            ->and($user->orders_count)->toBeBetween(1, 3);

        $user->orders()->with('items')->get()->each(function ($order) use ($user) {
            expect($order->email)->toBe($user->email)
                ->and($order->shipping_address['city'])->toBe($user->addresses->first()->city)
                ->and($order->items)->not->toBeEmpty()
                ->and($order->total)->toBe((int) $order->items->sum('total'));
        });
    });
});
