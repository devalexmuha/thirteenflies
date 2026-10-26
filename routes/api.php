<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CategoriesProductController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/config', [ConfigController::class, 'index'])->name('config.get');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/products', [CategoriesController::class, 'products'])->name('categories.products.index');



Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// MAKING API ENDPOINTS
// build all endpoints for categories

// endpoints for products
// build meta tags resolver
