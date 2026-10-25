<?php

use Illuminate\Support\Facades\Route;
use App\Enums\Locale;

Route::get('/', function () {
    return view('welcome');
});


// SEEDING DATABASE USER RELATED
// USER RELATED API ENDPOINTS

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

// BUILDING ADMIN PANEL
// build customers and orders resource
// getNavigationBadge() to show amt of new non resolved orders
// add diff colors on order status
// add nested resource for Customers resource to show orders of each user
// build dashboard
// implement user roles permissions with https://filamentphp.com/plugins/bezhansalleh-shield#1-install-package
