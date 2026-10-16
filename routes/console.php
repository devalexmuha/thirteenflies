<?php

use App\Models\Catalog\Promotion;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::call(function () {
    Promotion::query()
             ->where('is_active', true)
             ->where('sale_ends_at', '<', now())
             ->update(['is_active' => false]);
})->everyMinute();
