<?php

namespace Database\Seeders;

use App\Models\Account\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * The admin account; the admin panel lets in only this email.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@thirteenflies.com',
            'password' => 'pass',
        ]);
    }
}
