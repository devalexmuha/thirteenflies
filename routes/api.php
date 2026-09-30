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
// work on settings related


// review on product can add only user bought this product (in user -> orders -> complete -> exist this product)
// do not forget to add sorting functionality additionally to filtering
// how to build reliable api like web project with session and csrf tokens
// put | patch

// implement stripe checkout https://www.youtube.com/watch?v=J13Xe939Bh8
// php artisan make:middleware AttachRedirectOn404
// make shure all slugs are clean (fix ->unique)

// migrate (check unique on filter page),
// check how category relationships work? why I need node tait? Is only parent_id enough? What will happen to childs If some middle root category will be deleted?
// check what endpoints I will have for products and categories, how to make product live in route /stainwey-grad-piano-model-d-dlfd but know that this is a product
// make factories and seeding for products categories and users
// seed
// install filament
