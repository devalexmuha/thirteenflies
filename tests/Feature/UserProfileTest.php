<?php

use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('creates an empty profile whenever a user is created', function () {
    $user = User::factory()->create();

    expect($user->userProfile)->not->toBeNull()
        ->and($user->userProfile->first_name)->toBeNull();
});

it('returns the profile of a user created without registering', function () {
    Sanctum::actingAs(User::factory()->create(), ['*'], 'customer');

    $this->getJson('/api/v1/profile')
        ->assertOk()
        ->assertJsonPath('data.first_name', null);
});
