<?php

use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\DiscountsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionsController;
use Illuminate\Support\Facades\Route;

Route::get('/config', [ConfigController::class, 'index'])->name('config.get');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/products', [CategoriesController::class, 'products'])->name('categories.products.index');

Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [BrandsController::class, 'show'])->name('brands.show');
Route::get('/brands/{brand}/products', [BrandsController::class, 'products'])->name('brands.products.index');

Route::get('/discounts', [DiscountsController::class, 'index'])->name('discounts.index');
Route::get('/discounts/{discount}', [DiscountsController::class, 'show'])->name('discounts.show');
Route::get('/discounts/{discount}/products', [DiscountsController::class, 'products'])->name('discounts.products.index');

Route::get('/promotions', [PromotionsController::class, 'index'])->name('promotions.index');
Route::get('/promotions/{promotion}', [PromotionsController::class, 'show'])->name('promotions.show');
Route::get('/promotions/{promotion}/products', [PromotionsController::class, 'products'])->name('promotions.products.index');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// MAKING API ENDPOINTS
// add product meta tag resolver
// add to each route /filter

// build filter pages with redirects

// how client will know what filter attributes and values we have? how seo slug with filter page will work?
// will we have some list of attributes and values per category? will in this list we show what filter page have seo slug?
// if hit flt key which has seo slug, how will I respond?

// endpoints for products
// build product meta tags resolver
