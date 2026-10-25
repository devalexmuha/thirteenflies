<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
//            UserSeeder::class,
//            SeoTemplateSeeder::class,
            ContactSettingsSeeder::class,
//            CategorySeeder::class,
//            BrandSeeder::class,
//            PromotionSeeder::class,
//            DiscountSeeder::class,
//            ProductSeeder::class,
//            FilterPageSeeder::class,
//            AuthorSeeder::class,
//            ServiceSeeder::class,
//            ArticleSeeder::class,
//            PageSeeder::class,
        ]);
    }
}
