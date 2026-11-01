<?php

use App\Models\Account\User;
use App\Models\Catalog\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function shopUser(): User
{
    $user = User::factory()->create();
    $user->userProfile()->create();

    return $user;
}

function addressPayload(array $overrides = []): array
{
    return array_merge([
        'full_name' => 'John Doe',
        'phone' => '123456',
        'country' => 'USA',
        'city' => 'Austin',
        'zip' => '73301',
        'address_line_1' => '1 Main St',
    ], $overrides);
}

it('requires a token for the account routes', function () {
    $this->getJson('/api/profile')->assertUnauthorized();
    $this->getJson('/api/addresses')->assertUnauthorized();
    $this->getJson('/api/wishlist')->assertUnauthorized();
});

it('shows and updates the profile', function () {
    Sanctum::actingAs(shopUser());

    $this->patchJson('/api/profile', ['first_name' => 'John', 'last_name' => 'Doe', 'phone' => '123'])
        ->assertOk()
        ->assertJsonPath('data.first_name', 'John');

    $this->getJson('/api/profile')
        ->assertOk()
        ->assertJsonPath('data.last_name', 'Doe');
});

it('deletes the account together with its tokens', function () {
    $user = shopUser();
    $user->createToken('next-client');
    Sanctum::actingAs($user);

    $this->deleteJson('/api/profile')->assertNoContent();

    expect(User::count())->toBe(0)
        ->and(DB::table('personal_access_tokens')->count())->toBe(0);
});

it('creates, lists, updates and deletes own addresses', function () {
    Sanctum::actingAs($user = shopUser());

    $id = $this->postJson('/api/addresses', addressPayload())
        ->assertCreated()
        ->json('data.id');

    $this->getJson('/api/addresses')->assertOk()->assertJsonCount(1, 'data');

    $this->patchJson("/api/addresses/{$id}", addressPayload(['city' => 'Dallas']))
        ->assertOk()
        ->assertJsonPath('data.city', 'Dallas');

    $this->deleteJson("/api/addresses/{$id}")->assertNoContent();

    expect($user->addresses()->count())->toBe(0);
});

it('validates the address', function () {
    Sanctum::actingAs(shopUser());

    $this->postJson('/api/addresses', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['full_name', 'city', 'zip']);
});

it('keeps only one default address', function () {
    Sanctum::actingAs($user = shopUser());

    $this->postJson('/api/addresses', addressPayload(['is_default' => true]));
    $this->postJson('/api/addresses', addressPayload(['is_default' => true]));

    expect($user->addresses()->where('is_default', true)->count())->toBe(1);
});

it('hides addresses of other users', function () {
    $other = shopUser();
    $address = $other->addresses()->create(addressPayload());

    Sanctum::actingAs(shopUser());

    $this->getJson("/api/addresses/{$address->id}")->assertNotFound();
    $this->deleteJson("/api/addresses/{$address->id}")->assertNotFound();
});

it('adds, lists and removes wishlist products', function () {
    Sanctum::actingAs(shopUser());
    $product = Product::factory()->create(['name' => 'Guitar']);

    $this->postJson("/api/wishlist/{$product->id}")->assertNoContent();
    $this->postJson("/api/wishlist/{$product->id}")->assertNoContent();

    $this->getJson('/api/wishlist')->assertOk()->assertJsonCount(1, 'data');

    $this->deleteJson("/api/wishlist/{$product->id}")->assertNoContent();

    $this->getJson('/api/wishlist')->assertOk()->assertJsonCount(0, 'data');
});

it('uploads an avatar to the public disk', function () {
    Storage::fake('public');
    Sanctum::actingAs(shopUser());

    $path = $this->patchJson('/api/profile', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '123',
        'avatar' => UploadedFile::fake()->image('me.jpg'),
    ])
        ->assertOk()
        ->assertJsonStructure(['data' => ['avatar']])
        ->json('data.avatar');

    expect($path)->not->toBeNull();
    Storage::disk('public')->assertCount('avatars', 1);
});

it('rejects an avatar that is not an image', function () {
    Sanctum::actingAs(shopUser());

    $this->patchJson('/api/profile', ['avatar' => UploadedFile::fake()->create('cv.pdf', 10)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('avatar');
});

it('lets a patch change only some address fields', function () {
    Sanctum::actingAs($user = shopUser());
    $address = $user->addresses()->create(addressPayload());

    $this->patchJson("/api/addresses/{$address->id}", ['city' => 'Dallas'])
        ->assertOk()
        ->assertJsonPath('data.city', 'Dallas')
        ->assertJsonPath('data.full_name', 'John Doe');
});
