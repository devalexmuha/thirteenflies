<?php

namespace Database\Seeders;

use App\Models\Account\Address;
use App\Models\Account\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Every user gets one default address and up to two more.
     */
    public function run(): void
    {
        User::all()->each(function (User $user): void {
            Address::factory()->for($user)->default()->create();
            Address::factory()->count(fake()->numberBetween(0, 2))->for($user)->create();
        });
    }
}
