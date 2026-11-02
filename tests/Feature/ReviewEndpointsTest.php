<?php

use App\Enums\OrderStatus;
use App\Http\Resources\ProductResource;
use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use App\Models\Sales\Order;
use App\Models\Sales\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function orderWith(User $user, Product $product, OrderStatus $status = OrderStatus::Complete): void
{
    $order = Order::factory()->for($user)->create(['status' => $status]);

    OrderItem::factory()->for($order)->create(['product_id' => $product->id]);
}

it('lists the reviews of a product without a login', function () {
    $product = Product::factory()->create(['name' => 'Guitar']);
    User::factory()->count(2)->create()->each(fn (User $user) => Review::factory()->for($product)->for($user)->create());
    Review::factory()->for(Product::factory()->create(['name' => 'Piano']))->for(User::factory())->create();

    $this->getJson("/api/review/{$product->id}")
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('lets a user who bought the product store a review', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product);

    Sanctum::actingAs($user);

    $this->postJson("/api/review/{$product->id}", ['rating' => 5, 'body' => 'Great'])
        ->assertCreated()
        ->assertJsonPath('data.rating', 5);

    $this->assertDatabaseHas('reviews', ['user_id' => $user->id, 'product_id' => $product->id]);
    expect($product->fresh()->avr_rating)->toBe(5);
});

it('answers 403 when the user did not buy the product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);

    Sanctum::actingAs($user);

    $this->postJson("/api/review/{$product->id}", ['rating' => 5])->assertForbidden();
});

it('answers 403 when the order is not complete yet', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product, OrderStatus::Pending);

    Sanctum::actingAs($user);

    $this->postJson("/api/review/{$product->id}", ['rating' => 5])->assertForbidden();
});

it('answers 409 when the product is already reviewed', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product);
    Review::factory()->for($product)->for($user)->create();

    Sanctum::actingAs($user);

    $this->postJson("/api/review/{$product->id}", ['rating' => 4])->assertStatus(409);
});

it('validates the rating', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product);

    Sanctum::actingAs($user);

    $this->postJson("/api/review/{$product->id}", ['rating' => 9])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('rating');
});

it('requires a token to store a review', function () {
    $product = Product::factory()->create(['name' => 'Guitar']);

    $this->postJson("/api/review/{$product->id}", ['rating' => 5])->assertUnauthorized();
});

it('updates the own review', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product);
    Review::factory()->for($product)->for($user)->create(['rating' => 2]);

    Sanctum::actingAs($user);

    $this->patchJson("/api/review/{$product->id}", ['rating' => 4])
        ->assertOk()
        ->assertJsonPath('data.rating', 4);
});

it('answers 403 on update when the user did not buy the product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    Review::factory()->for($product)->for($user)->create();

    Sanctum::actingAs($user);

    $this->patchJson("/api/review/{$product->id}", ['rating' => 4])->assertForbidden();
});

it('answers 404 on update when the user has no review of the product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);

    Sanctum::actingAs($user);

    $this->patchJson("/api/review/{$product->id}", ['rating' => 4])->assertNotFound();
});

it('deletes the own review only', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    $review = Review::factory()->for($product)->for($user)->create();
    $other = Review::factory()->for($product)->for(User::factory())->create();

    Sanctum::actingAs($user);

    $this->deleteJson("/api/review/{$product->id}")->assertNoContent();

    $this->assertModelMissing($review);
    $this->assertModelExists($other);
});

it('requires a token to update a review', function () {
    $product = Product::factory()->create(['name' => 'Guitar']);

    $this->patchJson("/api/review/{$product->id}", ['rating' => 4])->assertUnauthorized();
});

it('validates the rating on update', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Guitar']);
    orderWith($user, $product);
    Review::factory()->for($product)->for($user)->create();

    Sanctum::actingAs($user);

    $this->patchJson("/api/review/{$product->id}", ['rating' => 9])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('rating');
});

it('requires a token to delete a review', function () {
    $product = Product::factory()->create(['name' => 'Guitar']);

    $this->deleteJson("/api/review/{$product->id}")->assertUnauthorized();
});

it('answers 404 on delete when the user has no review of the product', function () {
    $product = Product::factory()->create(['name' => 'Guitar']);

    Sanctum::actingAs(User::factory()->create());

    $this->deleteJson("/api/review/{$product->id}")->assertNotFound();
});
