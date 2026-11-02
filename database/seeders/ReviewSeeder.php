<?php

namespace Database\Seeders;

use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Every product gets three to five reviews, each from a different random user.
     */
    public function run(): void
    {
        $users = User::all();

        Product::all()->each(function (Product $product) use ($users): void {
            $users->random(min(fake()->numberBetween(3, 5), $users->count()))
                ->each(fn (User $user) => Review::factory()->for($product)->for($user)->create());
        });
    }
}
