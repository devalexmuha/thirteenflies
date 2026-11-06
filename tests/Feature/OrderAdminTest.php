<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Sales\Orders\Pages\EditOrder;
use App\Filament\Resources\Sales\Orders\RelationManagers\OrderItemsRelationManager;
use App\Models\Account\Admin;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    foreach (['ViewAny:Order', 'View:Order', 'Update:Order'] as $permission) {
        Permission::findOrCreate($permission, 'admin');
    }

    $this->actingAs(Admin::factory()->create()->givePermissionTo('ViewAny:Order', 'View:Order', 'Update:Order'), 'admin');
    Filament::setCurrentPanel('admin');

    $this->order = Order::factory()->create(['subtotal' => 2000, 'total' => 2000]);
});

it('updates only the order status', function () {
    Livewire::test(EditOrder::class, ['record' => $this->order->id])
        ->assertSee('20.00')
        ->fillForm(['status' => OrderStatus::Complete])
        ->call('save')
        ->assertHasNoFormErrors();

    $order = $this->order->fresh();

    expect($order->status)->toBe(OrderStatus::Complete)
        ->and($order->payment_status)->toBe(PaymentStatus::Unpaid)
        ->and($order->getRawOriginal('total'))->toBe(2000);
});

it('lists the items with the price saved on the item and a link to the product', function () {
    $product = Product::factory()->create(['name' => 'Guitar', 'price' => 50]);
    $this->order->items()->create(['product_id' => $product->id, 'sku' => $product->sku, 'price' => 1000, 'quantity' => 2, 'total' => 2000]);

    Livewire::test(OrderItemsRelationManager::class, ['ownerRecord' => $this->order, 'pageClass' => EditOrder::class])
        ->assertSee('Guitar')
        ->assertSee('$10.00')
        ->assertSee('$20.00')
        ->assertSeeHtml('/admin/catalog/products/'.$product->id.'/edit');
});
