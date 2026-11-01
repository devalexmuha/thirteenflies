<?php

namespace App\Providers;

use App\Jobs\CompressMedia;
use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Media::created(fn (Media $media) => CompressMedia::dispatch($media));

        // {address} in a route is searched only among the addresses of the logged in user.
        Route::bind('address', fn (string $id) => request()->user()->addresses()->findOrFail($id));

        Translatable::fallback(
            fallbackLocale: 'en',
            fallbackAny: true,
        );
    }
}
