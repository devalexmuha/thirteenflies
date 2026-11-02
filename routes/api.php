<?php

use App\Http\Controllers\Api\AddressesController;
use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SessionController;
use App\Http\Controllers\Api\AuthorsController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\DiscountsController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\RedirectsController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RobotsTxtController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\SitemapController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

// Settings
Route::get('/config', [ConfigController::class, 'index'])->name('config.get');

// Catalog
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/products',
    [CategoriesController::class, 'products'])->name('categories.products.index');
Route::get('/categories/{category}/filters',
    [CategoriesController::class, 'filters'])->name('categories.filters.index');

Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [BrandsController::class, 'show'])->name('brands.show');
Route::get('/brands/{brand}/products', [BrandsController::class, 'products'])->name('brands.products.index');
Route::get('/brands/{brand}/filters', [BrandsController::class, 'filters'])->name('brands.filters.index');

Route::get('/discounts', [DiscountsController::class, 'index'])->name('discounts.index');
Route::get('/discounts/{discount}', [DiscountsController::class, 'show'])->name('discounts.show');
Route::get('/discounts/{discount}/products',
    [DiscountsController::class, 'products'])->name('discounts.products.index');
Route::get('/discounts/{discount}/filters', [DiscountsController::class, 'filters'])->name('discounts.filters.index');

Route::get('/promotions', [PromotionsController::class, 'index'])->name('promotions.index');
Route::get('/promotions/{promotion}', [PromotionsController::class, 'show'])->name('promotions.show');
Route::get('/promotions/{promotion}/products',
    [PromotionsController::class, 'products'])->name('promotions.products.index');
Route::get('/promotions/{promotion}/filters',
    [PromotionsController::class, 'filters'])->name('promotions.filters.index');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Content
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

// SEO
Route::get('/redirects', [RedirectsController::class, 'index'])->name('redirects.index');
Route::get('/redirects/lookup', [RedirectsController::class, 'show'])->name('redirects.show');

Route::get('/robots-txt', [RobotsTxtController::class, 'show'])->name('robots-txt.show');

Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/lookup', [SitemapController::class, 'show'])->name('sitemap.show');

// User
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:10,1');
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy']);

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addresses', [AddressesController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressesController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}', [AddressesController::class, 'show'])->name('addresses.show');
    Route::patch('/addresses/{address}', [AddressesController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressesController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product:id}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product:id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::post('/review/{product:id}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/review/{product:id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{product:id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::get('/review/{product:id}', [ReviewController::class, 'index'])->name('reviews.index');

// implement cart

// implement stripe checkout https://www.youtube.com/watch?v=J13Xe939Bh8

// /orders index
// /orders/id show
// /orders/id/cancel delete

// SEEDING DATABASE USER RELATED

// notify user with email with his order created and every time status changes: notify.
