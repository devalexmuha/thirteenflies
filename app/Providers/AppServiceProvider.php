<?php

namespace App\Providers;

use App\Jobs\CompressMedia;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        Factory::guessFactoryNamesUsing(
            fn(string $model) => 'Database\\Factories\\'.class_basename($model).'Factory'
        );

        Media::created(fn(Media $media) => CompressMedia::dispatch($media));

        Translatable::fallback(
            fallbackLocale: 'en',
            fallbackAny: true,
        );
    }
}
