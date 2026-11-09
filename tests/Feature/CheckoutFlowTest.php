<?php

use App\Enums\PaymentStatus;
use App\Models\Account\Address;
use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use App\Notifications\OrderGotPaid;
use App\Services\CreatePaymentUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function makeProduct(): Product
{
    return Product::factory()->create(['name' => 'Guitar', 'price' => 50, 'stock_qty' => 10, 'in_stock' => true, 'is_active' => true]);
}

function placeOrder(User $user): Order
{
    $address = Address::factory()->for($user)->create();

    test()->postJson('/api/v1/cart/'.makeProduct()->id)->assertCreated();

    $id = test()->postJson('/api/v1/orders', ['address_id' => $address->id])->assertCreated()->json('data.id');

    return Order::findOrFail($id);
}

function sendStripeEvent(string $type, array $session, string $secret = 'whsec_test')
{
    $payload = json_encode(['id' => 'evt_test_1', 'object' => 'event', 'type' => $type, 'data' => ['object' => $session]]);
    $timestamp = time();
    $signature = 't='.$timestamp.',v1='.hash_hmac('sha256', $timestamp.'.'.$payload, $secret);

    return test()->call('POST', '/api/v1/payment/webhook', [], [], [], [
        'CONTENT_TYPE' => 'application/json',
        'HTTP_STRIPE_SIGNATURE' => $signature,
    ], $payload);
}

it('registers a user and returns a token', function () {
    $this->postJson('/api/v1/register', [
        'email' => 'new@example.com',
        'password' => 'secret',
        'password_confirmation' => 'secret',
    ])
        ->assertCreated()
        ->assertJsonStructure(['data' => ['user', 'token']]);

    expect(User::where('email', 'new@example.com')->first()->userProfile)->not->toBeNull();
});

it('logs a registered user in with the right password only', function () {
    User::factory()->create(['email' => 'jane@example.com', 'password' => 'secret']);

    $this->postJson('/api/v1/login', ['email' => 'jane@example.com', 'password' => 'secret'])
        ->assertOk()
        ->assertJsonStructure(['data' => ['user', 'token']]);

    $this->postJson('/api/v1/login', ['email' => 'jane@example.com', 'password' => 'wrong'])
        ->assertUnauthorized();
});

it('adds a product to the cart', function () {
    Sanctum::actingAs(User::factory()->create());
    $product = makeProduct();

    $this->postJson('/api/v1/cart/'.$product->id)->assertCreated();

    $this->getJson('/api/v1/cart')->assertOk()->assertJsonFragment(['quantity' => 1]);
    $this->postJson('/api/v1/cart/'.$product->id)->assertStatus(409);
});

it('turns the cart into an order, empties the cart and reduces the stock', function () {
    Sanctum::actingAs($user = User::factory()->create());

    $order = placeOrder($user);

    expect($order->payment_status)->toBe(PaymentStatus::Unpaid)
        ->and($order->total)->toBe(5000)
        ->and($order->items)->toHaveCount(1)
        ->and($user->cart->items)->toHaveCount(0)
        ->and(Product::first()->stock_qty)->toBe(9);
});

it('starts a checkout and marks the order paid when Stripe confirms the payment', function () {
    Notification::fake();
    config(['services.stripe.webhook_secret' => 'whsec_test']);

    $this->mock(CreatePaymentUrl::class, function ($mock) {
        $mock->shouldReceive('make')->once()->andReturnUsing(function (Order $order) {
            $order->payments()->create(['amount' => $order->total, 'currency' => $order->currency, 'checkout_session_id' => 'cs_test_123']);

            return 'https://checkout.stripe.test/pay/cs_test_123';
        });
    });

    Sanctum::actingAs($user = User::factory()->create());
    $order = placeOrder($user);

    $this->postJson('/api/v1/payment/'.$order->id)
        ->assertOk()
        ->assertJsonPath('data.payment_url', 'https://checkout.stripe.test/pay/cs_test_123');

    expect($order->fresh()->payment_status)->toBe(PaymentStatus::Unpaid);

    sendStripeEvent('checkout.session.completed', ['id' => 'cs_test_123', 'object' => 'checkout.session', 'payment_status' => 'paid'])
        ->assertNoContent();

    expect($order->fresh()->payment_status)->toBe(PaymentStatus::Paid)
        ->and($order->payments()->first()->status)->toBe(PaymentStatus::Paid);

    Notification::assertSentTo($user, OrderGotPaid::class);

    $this->postJson('/api/v1/payment/'.$order->id)->assertStatus(409);
});

it('ignores a Stripe webhook with a wrong signature', function () {
    config(['services.stripe.webhook_secret' => 'whsec_test']);
    $order = Order::factory()->create();
    $order->payments()->create(['amount' => $order->total, 'checkout_session_id' => 'cs_test_456']);

    sendStripeEvent('checkout.session.completed', ['id' => 'cs_test_456', 'object' => 'checkout.session', 'payment_status' => 'paid'], 'whsec_wrong')
        ->assertStatus(400);

    expect($order->fresh()->payment_status)->toBe(PaymentStatus::Unpaid);
});

it('does not let a user pay another user\'s order', function () {
    $order = Order::factory()->create();

    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/v1/payment/'.$order->id)->assertNotFound();
});
