<?php

use App\Models\Account\Address;
use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('turns the cart into an order, reduces stock and empties the cart', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create();
    $product = Product::factory()->create(['name' => 'Guitar', 'price' => 10, 'discount_price' => null, 'stock_qty' => 5, 'is_active' => true]);
    $user->cart()->create()->items()->create(['product_id' => $product->id, 'quantity' => 2]);

    Sanctum::actingAs($user);

    $this->postJson('/api/orders', ['address_id' => $address->id, 'customer_note' => 'Call me'])
        ->assertCreated()
        ->assertJsonPath('data.status', 'pending')
        ->assertJsonPath('data.total', 20)
        ->assertJsonPath('data.items.0.quantity', 2);

    expect($product->fresh()->stock_qty)->toBe(3)
        ->and($user->cart->items()->count())->toBe(0);

    $this->assertDatabaseHas('order_status_logs', ['status' => 'pending']);
});

it('refuses to order an empty cart or another user\'s address', function () {
    $user = User::factory()->create();
    $foreignAddress = Address::factory()->create();

    Sanctum::actingAs($user);

    $this->postJson('/api/orders', ['address_id' => $foreignAddress->id])->assertUnprocessable();

    $address = Address::factory()->for($user)->create();
    $this->postJson('/api/orders', ['address_id' => $address->id])->assertUnprocessable();
});

it('lists and shows only the user\'s own orders', function () {
    $user = User::factory()->create();
    $mine = Order::factory()->for($user)->create();
    $other = Order::factory()->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/orders')->assertOk()->assertJsonCount(1, 'data');
    $this->getJson("/api/orders/{$mine->id}")->assertOk()->assertJsonPath('data.number', $mine->number);
    $this->getJson("/api/orders/{$other->id}")->assertNotFound();
});

it('cancels a pending order and returns the stock', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar', 'stock_qty' => 3]);
    $order = Order::factory()->for($user)->create();
    $order->items()->create(['product_id' => $product->id, 'sku' => $product->sku, 'price' => 100, 'quantity' => 2, 'total' => 200]);

    Sanctum::actingAs($user);

    $this->patchJson("/api/orders/{$order->id}")->assertOk()->assertJsonPath('data.status', 'canceled');

    expect($product->fresh()->stock_qty)->toBe(5);

    $this->patchJson("/api/orders/{$order->id}")->assertStatus(409);
});
