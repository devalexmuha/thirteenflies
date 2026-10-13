<?php

use Illuminate\Support\Facades\Route;
use App\Enums\Locale;

Route::get('/', function () {
    return view('welcome');
});
