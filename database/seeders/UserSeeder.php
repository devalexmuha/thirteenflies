<?php

namespace Database\Seeders;

use App\Models\Account\User;
use App\Models\Account\UserProfile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Five shop customers with a profile, all with the password "pass".
     */
    public function run(): void
    {
        User::factory()
            ->count(5)
            ->create(['password' => 'pass'])
            ->each(fn (User $user) => $user->userProfile->update(
                UserProfile::factory()->raw(['user_id' => $user->id])
            ));
    }
}
