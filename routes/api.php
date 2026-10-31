<?php

use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\AuthorsController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\DiscountsController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\RedirectsController;
use App\Http\Controllers\Api\RobotsTxtController;
use App\Http\Controllers\Api\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/config', [ConfigController::class, 'index'])->name('config.get');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/products', [CategoriesController::class, 'products'])->name('categories.products.index');
Route::get('/categories/{category}/filters', [CategoriesController::class, 'filters'])->name('categories.filters.index');

Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [BrandsController::class, 'show'])->name('brands.show');
Route::get('/brands/{brand}/products', [BrandsController::class, 'products'])->name('brands.products.index');
Route::get('/brands/{brand}/filters', [BrandsController::class, 'filters'])->name('brands.filters.index');

Route::get('/discounts', [DiscountsController::class, 'index'])->name('discounts.index');
Route::get('/discounts/{discount}', [DiscountsController::class, 'show'])->name('discounts.show');
Route::get('/discounts/{discount}/products', [DiscountsController::class, 'products'])->name('discounts.products.index');
Route::get('/discounts/{discount}/filters', [DiscountsController::class, 'filters'])->name('discounts.filters.index');

Route::get('/promotions', [PromotionsController::class, 'index'])->name('promotions.index');
Route::get('/promotions/{promotion}', [PromotionsController::class, 'show'])->name('promotions.show');
Route::get('/promotions/{promotion}/products', [PromotionsController::class, 'products'])->name('promotions.products.index');
Route::get('/promotions/{promotion}/filters', [PromotionsController::class, 'filters'])->name('promotions.filters.index');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticlesController::class, 'show'])->name('articles.show');

Route::get('/authors', [AuthorsController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorsController::class, 'show'])->name('authors.show');
Route::get('/authors/{author}/articles', [AuthorsController::class, 'articles'])->name('authors.articles.index');
Route::get('/authors/{author}/services', [AuthorsController::class, 'services'])->name('authors.services.index');

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServicesController::class, 'show'])->name('services.show');

Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
Route::get('/pages/{page}', [PagesController::class, 'show'])->name('pages.show');

Route::get('/redirects', [RedirectsController::class, 'index'])->name('redirects.index');
Route::get('/redirects/lookup', [RedirectsController::class, 'show'])->name('redirects.show');

Route::get('/robots-txt', [RobotsTxtController::class, 'show'])->name('robots-txt.show');

// MAKING API ENDPOINTS

// setup sitemap.xml

// API ENDPOINTS USER RELATED
// FINISH ADMIN PANEL
// remove claude from repo
