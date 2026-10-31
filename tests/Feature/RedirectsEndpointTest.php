<?php

use App\Models\Seo\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function redirectRow(array $attributes = []): Redirect
{
    return Redirect::create($attributes + [
        'from_path' => '/old-page',
        'to_path' => '/new-page',
        'status_code' => 301,
        'hits' => 0,
        'is_active' => true,
    ]);
}

it('returns where to send the visitor and counts the hit', function () {
    $redirect = redirectRow();

    $this->getJson('/api/redirects/lookup?path=/old-page')
        ->assertOk()
        ->assertExactJson(['data' => ['to' => '/new-page', 'status_code' => 301]]);

    expect($redirect->refresh())
        ->hits->toBe(1)
        ->last_hit_at->not->toBeNull();
});

it('finds the redirect with or without a trailing slash', function () {
    redirectRow();

    $this->getJson('/api/redirects/lookup?path=/old-page/')->assertOk();
});

it('answers 404 when there is no redirect for the path or it is switched off', function () {
    redirectRow(['from_path' => '/disabled', 'is_active' => false]);

    $this->getJson('/api/redirects/lookup?path=/nothing-here')->assertNotFound();
    $this->getJson('/api/redirects/lookup?path=/disabled')->assertNotFound();
});

it('asks for the path when it is missing', function () {
    $this->getJson('/api/redirects/lookup')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('path');
});

it('lists every active redirect', function () {
    redirectRow();
    redirectRow(['from_path' => '/disabled', 'is_active' => false]);

    $this->getJson('/api/redirects')
        ->assertOk()
        ->assertExactJson(['data' => [['from' => '/old-page', 'to' => '/new-page', 'status_code' => 301]]]);
});
