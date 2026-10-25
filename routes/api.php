<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{category}', [CategoriesController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// MAKING API ENDPOINTS



