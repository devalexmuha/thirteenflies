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

// BUILDING ADMIN PANEL
// on categories create attributes
// on products create values
// fill in catalog functionality from the admin prospective + filter pages

// how seo json ld templates will work?
// before next seeding refactor factories by mirroring models namespaces

// review on product can add only user bought this product (in user -> orders -> complete -> exist this product)
// do not forget to add sorting functionality additionally to filtering
// how to build reliable api like web project with session and csrf tokens + what are the endpoints?
// learn all types off endpoints I'll have (which next.js will fetch from per page load)
// put | patch

// implement stripe checkout https://www.youtube.com/watch?v=J13Xe939Bh8
// php artisan make:middleware AttachRedirectOn404
// delete media files on model deletion
// implement json ld as separate feature
// show available variables on categories for prod meta templates

// who is added global search?
