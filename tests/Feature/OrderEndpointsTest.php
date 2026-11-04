<?php

use App\Models\Account\Address;
use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('requires a login on every order route', function () {
    $order = Order::factory()->create();

    $this->getJson('/api/orders')->assertUnauthorized();
    $this->getJson("/api/orders/{$order->id}")->assertUnauthorized();
    $this->postJson('/api/orders')->assertUnauthorized();
    $this->patchJson("/api/orders/{$order->id}")->assertUnauthorized();
});

// GET /api/orders

it('lists only the user\'s own orders with their items', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    $mine = Order::factory()->for($user)->create();
    $mine->items()->create(['product_id' => $product->id, 'sku' => $product->sku, 'price' => 100, 'quantity' => 2, 'total' => 200]);
    Order::factory()->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/orders')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.number', $mine->number)
        ->assertJsonPath('data.0.items.0.quantity', 2);
});

// GET /api/orders/{order}

it('shows the user\'s own order with its items', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    $order = Order::factory()->for($user)->create();
    $order->items()->create(['product_id' => $product->id, 'sku' => $product->sku, 'price' => 100, 'quantity' => 2, 'total' => 200]);

    Sanctum::actingAs($user);

    $this->getJson("/api/orders/{$order->id}")
        ->assertOk()
        ->assertJsonPath('data.number', $order->number)
        ->assertJsonPath('data.items.0.sku', $product->sku)
        ->assertJsonPath('data.items.0.price', 1)
        ->assertJsonPath('data.items.0.total', 2);
});

it('returns 404 when showing another user\'s order', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->getJson('/api/orders/'.Order::factory()->create()->id)->assertNotFound();
});

// POST /api/orders

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
        ->assertJsonPath('data.customer_note', 'Call me')
        ->assertJsonPath('data.shipping_address.city', $address->city)
        ->assertJsonPath('data.items.0.quantity', 2);

    expect($product->fresh()->stock_qty)->toBe(3)
        ->and($user->cart->items()->count())->toBe(0);

    $this->assertDatabaseHas('order_status_logs', ['status' => 'pending']);
});

it('refuses to order without an address or with another user\'s address', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/orders')->assertUnprocessable()->assertJsonValidationErrors('address_id');
    $this->postJson('/api/orders', ['address_id' => Address::factory()->create()->id])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('address_id');
});

it('refuses to order an empty cart', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $this->postJson('/api/orders', ['address_id' => $address->id])->assertUnprocessable();

    expect(Order::count())->toBe(0);
});

it('refuses to order more than is in stock and changes nothing', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create();
    $product = Product::factory()->create(['name' => 'Guitar', 'stock_qty' => 1, 'is_active' => true]);
    $user->cart()->create()->items()->create(['product_id' => $product->id, 'quantity' => 2]);

    Sanctum::actingAs($user);

    $this->postJson('/api/orders', ['address_id' => $address->id])->assertUnprocessable();

    expect(Order::count())->toBe(0)
        ->and($product->fresh()->stock_qty)->toBe(1)
        ->and($user->cart->items()->count())->toBe(1);
});

// PATCH /api/orders/{order}

it('cancels a pending order and returns the stock', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar', 'stock_qty' => 3]);
    $order = Order::factory()->for($user)->create();
    $order->items()->create(['product_id' => $product->id, 'sku' => $product->sku, 'price' => 100, 'quantity' => 2, 'total' => 200]);

    Sanctum::actingAs($user);

    $this->patchJson("/api/orders/{$order->id}")->assertOk()->assertJsonPath('data.status', 'canceled');

    expect($product->fresh()->stock_qty)->toBe(5);

    $this->assertDatabaseHas('order_status_logs', ['order_id' => $order->id, 'status' => 'canceled']);

    $this->patchJson("/api/orders/{$order->id}")->assertStatus(409);
});

it('does not cancel an order that is no longer pending', function () {
    $user = User::factory()->create();
    $order = Order::factory()->complete()->for($user)->create();

    Sanctum::actingAs($user);

    $this->patchJson("/api/orders/{$order->id}")->assertStatus(409);
});

it('returns 404 when canceling another user\'s order', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->patchJson('/api/orders/'.Order::factory()->create()->id)->assertNotFound();
});
