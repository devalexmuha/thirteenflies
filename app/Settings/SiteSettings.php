<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $phone_numbers;
    public array $working_hours;
    public array $socials;
    public array $menus;
    public array $banners;

    public static function group(): string
    {
        return 'site';
    }
}
