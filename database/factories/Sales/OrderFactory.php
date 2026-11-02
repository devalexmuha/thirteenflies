<?php

namespace Database\Factories\Sales;

use App\Enums\OrderStatus;
use App\Models\Account\User;
use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(1_000, 500_000);

        return [
            'user_id' => User::factory(),
            'email' => fake()->safeEmail(),
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'shipping_address' => ['city' => fake()->city(), 'address_line_1' => fake()->streetAddress()],
        ];
    }

    public function complete(): static
    {
        return $this->state(['status' => OrderStatus::Complete]);
    }
}
