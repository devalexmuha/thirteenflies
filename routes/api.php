<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/config', [ConfigController::class, 'index'])->name('config.get');

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{category}', [CategoriesController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// MAKING API ENDPOINTS
// seed data for settings
