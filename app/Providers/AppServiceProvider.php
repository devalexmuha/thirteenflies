<?php

namespace App\Providers;

use App\Jobs\CompressMedia;
use App\Policies\MediaPolicy;
use Awcodes\Curator\Models\Media;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\Facades\Gate;
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

        FilamentShield::enforcePolicies(); // Gate::policy() for filament recourses
        Gate::policy(Media::class, MediaPolicy::class);

        Translatable::fallback(
            fallbackLocale: 'en',
            fallbackAny: true,
        );
    }
}
