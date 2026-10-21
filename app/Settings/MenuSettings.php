<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MenuSettings extends Settings
{

    public array $menus;

    public static function group(): string
    {
        return 'menus';
    }
}
