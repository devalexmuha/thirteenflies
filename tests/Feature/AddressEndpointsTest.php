<?php

use App\Models\Account\Address;
use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function addressData(array $overrides = []): array
{
    return array_merge([
        'full_name' => 'John Doe',
        'phone' => '123456',
        'country' => 'USA',
        'state' => 'Texas',
        'city' => 'Austin',
        'zip' => '73301',
        'address_line_1' => '1 Main St',
        'address_line_2' => null,
        'is_default' => false,
    ], $overrides);
}

it('lists only the addresses of the logged in user', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->for($user)->create();
    Address::factory()->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/addresses')
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('stores a new address for the logged in user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/addresses', addressData())
        ->assertCreated()
        ->assertJsonPath('data.city', 'Austin');

    $this->assertDatabaseHas('addresses', ['user_id' => $user->id, 'city' => 'Austin']);
});

it('shows one address', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create(['city' => 'Boston']);

    Sanctum::actingAs($user);

    $this->getJson("/api/addresses/{$address->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $address->id)
        ->assertJsonPath('data.city', 'Boston');
});

it('updates an address', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create(['city' => 'Boston']);

    Sanctum::actingAs($user);

    $this->patchJson("/api/addresses/{$address->id}", addressData(['city' => 'Dallas']))
        ->assertOk()
        ->assertJsonPath('data.city', 'Dallas');

    $this->assertDatabaseHas('addresses', ['id' => $address->id, 'city' => 'Dallas']);
});

it('deletes an address', function () {
    $user = User::factory()->create();
    $address = Address::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $this->deleteJson("/api/addresses/{$address->id}")->assertNoContent();

    $this->assertModelMissing($address);
});
