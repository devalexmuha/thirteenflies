<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{category}', [CategoriesController::class, 'show']);
Route::post('/categories/', [CategoriesController::class, 'store']);
Route::patch('/categories/{category}', [CategoriesController::class, 'update']);
Route::put('/categories/{category}', [CategoriesController::class, 'update']);
Route::delete('/categories/{category}', [CategoriesController::class, 'destroy']);


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// BUILDING DB STRUCTURE
// setup translations with require spatie/laravel-translatable
// work on products categories brands sales
// work on filters
// work on seo related (top and bottom seo text, title, description, h1, robots)
// work on checkout related
// work on settings related

// do not forget abt ratingable (products, articles, services) => "Content topic"
// review on product can add only user bought this product (in user -> orders -> complete -> exist this product)
// do not forget to add sorting functionality additionally to filtering
// how to build reliable api like web project with session and csrf tokens
// put | patch
// implement stripe checkout https://www.youtube.com/watch?v=J13Xe939Bh8
// php artisan make:middleware AttachRedirectOn404
// for writing redirects for seo filter page feature, check filter page model
// make shure all slugs are clean (fix ->unique)
// add mediable (featured image, baner image, etc type of image)

