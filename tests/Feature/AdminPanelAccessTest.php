<?php

use App\Models\Account\Admin;
use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lets an admin into the admin panel', function () {
    $this->actingAs(Admin::factory()->create(), 'admin')
        ->get('/admin')
        ->assertOk();
});

it('keeps a shop user out of the admin panel', function () {
    $this->actingAs(User::factory()->create())
        ->get('/admin')
        ->assertRedirect('/admin/login');
});
