<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SeoTemplateSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            PromotionSeeder::class,
            DiscountSeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
