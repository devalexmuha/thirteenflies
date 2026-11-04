<?php

use App\Models\Account\User;
use App\Models\Catalog\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lets a user log in, fill the cart, change quantities, remove an item and clear the cart', function () {
    $user = User::factory()->create(['password' => 'secret-pass']);
    $guitar = Product::factory()->create(['name' => 'Guitar', 'stock_qty' => 10]);
    $drums = Product::factory()->create(['name' => 'Drums', 'stock_qty' => 10]);

    $token = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'secret-pass'])
        ->assertOk()
        ->json('data.token');

    $this->withToken($token);

    // add the first item
    $this->postJson("/api/cart/{$guitar->id}")
        ->assertCreated()
        ->assertJsonCount(1, 'data.items')
        ->assertJsonPath('data.items.0.quantity', 1);

    // add another item
    $this->postJson("/api/cart/{$drums->id}")
        ->assertCreated()
        ->assertJsonCount(2, 'data.items');

    // increase the quantity of the second item
    $this->patchJson("/api/cart/{$drums->id}", ['quantity' => 3])->assertOk();

    $this->assertDatabaseHas('cart_items', ['product_id' => $drums->id, 'quantity' => 3]);
    $this->assertDatabaseHas('cart_items', ['product_id' => $guitar->id, 'quantity' => 1]);

    // remove the first item, the second stays
    $this->deleteJson("/api/cart/{$guitar->id}")
        ->assertOk()
        ->assertJsonCount(1, 'data.items')
        ->assertJsonPath('data.items.0.product.id', $drums->id)
        ->assertJsonPath('data.items.0.quantity', 3);

    $this->assertDatabaseMissing('cart_items', ['product_id' => $guitar->id]);

    // clear the cart
    $this->deleteJson('/api/cart')->assertNoContent();

    $this->assertDatabaseCount('cart_items', 0);

    $this->getJson('/api/cart')
        ->assertOk()
        ->assertJsonCount(0, 'data.items');
});
