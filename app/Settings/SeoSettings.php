<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public string $robots_txt;

    public static function group(): string
    {
        return 'seo';
    }
}
