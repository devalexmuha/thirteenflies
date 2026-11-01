<?php

namespace Database\Seeders;

use App\Models\Account\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@thirteenflies.com',
            'password' => 'pass',
        ]);
    }
}
