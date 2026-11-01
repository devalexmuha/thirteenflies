<?php

namespace Database\Seeders;

use App\Models\Account\User;
use App\Models\Catalog\Product;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Every user gets two to five random active products in the wishlist.
     */
    public function run(): void
    {
        User::all()->each(function (User $user): void {
            $productIds = Product::active()
                ->inRandomOrder()
                ->limit(fake()->numberBetween(2, 5))
                ->pluck('id');

            $user->wishlist()->syncWithoutDetaching($productIds);
        });
    }
}
