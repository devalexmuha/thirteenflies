<?php

use App\Models\Account\Admin;
use App\Models\Catalog\Product;
use App\Models\Content\Page;
use App\Policies\Account\AdminPolicy;
use App\Policies\Catalog\ProductPolicy;
use App\Policies\Content\PagePolicy;
use App\Policies\MediaPolicy;
use Awcodes\Curator\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

test('each shield model resolves to its generated policy', function (string $model, string $policy) {
    expect(Gate::getPolicyFor($model))->toBeInstanceOf($policy);
})->with([
    'product' => [Product::class, ProductPolicy::class],
    'page' => [Page::class, PagePolicy::class],
    'admin' => [Admin::class, AdminPolicy::class],
    'media' => [Media::class, MediaPolicy::class],
]);

test('an admin can only do what their role permissions allow', function () {
    Permission::findOrCreate('View:Page', 'admin');
    Permission::findOrCreate('Delete:Page', 'admin');

    $admin = Admin::factory()->create();
    $admin->givePermissionTo('View:Page');

    $page = new Page;

    expect($admin->can('view', $page))->toBeTrue()
        ->and($admin->can('delete', $page))->toBeFalse()
        ->and($admin->can('view', new Product))->toBeFalse();
});
