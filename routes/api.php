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

// how to build reliable api like web project with session and csrf tokens
// put | patch
