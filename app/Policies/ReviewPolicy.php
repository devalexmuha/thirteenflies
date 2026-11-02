<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Models\Account\User;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;

class ReviewPolicy
{
    public function create(User $user, Product $product): bool
    {
        return $this->hasBought($user, $product);
    }

    public function update(User $user, Review $review): bool
    {
        return $user->is($review->user) && $this->hasBought($user, $review->product);
    }

    /**
     * The user has a complete order which contains the product.
     */
    private function hasBought(User $user, Product $product): bool
    {
        return $user->orders()
            ->where('status', OrderStatus::Complete)
            ->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->exists();
    }
}
