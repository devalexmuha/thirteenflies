<?php

namespace Database\Seeders;

use App\Models\Access\Role;
use App\Models\Account\User;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. One admin user
        User::create([
            'email'    => 'admin@thirteenflies.com',
            'password' => 'password',              // 'hashed' cast hashes it
        ]);

        // 2. Three categories:
        //    Ukuleles              (no children)
        //    Guitars
        //     └── Electric Guitars (child)
        $ukuleles = Category::create(['name' => ['en' => 'Ukuleles']]);

        $guitars = Category::create([
            'name' => ['en' => 'Guitars'],
            'children' => [
                ['name' => ['en' => 'Electric Guitars']],
            ],
        ]);

        $electric = $guitars->children()->first();

        // 3. 15 products
        Product::factory(5)->create()->each(fn (Product $p) => $p->categories()->attach($ukuleles->id));
        Product::factory(10)->create()->each(fn (Product $p) => $p->categories()->attach($electric->id));
    }
}
