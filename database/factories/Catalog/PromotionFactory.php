<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Starts now and ends in 2 weeks to 6 months. The later it ends, the smaller the discount: 35% down to 5%.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $earliest = now()->addWeeks(2);
        $latest = now()->addMonths(6);

        $endsAt = Carbon::instance(fake()->dateTimeBetween($earliest, $latest));
        $progress = ($endsAt->timestamp - $earliest->timestamp) / ($latest->timestamp - $earliest->timestamp);

        return [
            'is_active' => true,
            'sale_starts_at' => now(),
            'sale_ends_at' => $endsAt,
            'discount_rate' => round(35 - 30 * $progress),
        ];
    }
}
