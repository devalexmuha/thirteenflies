<?php

namespace Database\Seeders;

use App\Models\Account\Address;
use App\Models\Account\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Every user gets exactly one address, the default one.
     */
    public function run(): void
    {
        User::all()->each(fn (User $user) => Address::factory()->for($user)->default()->create());
    }
}
