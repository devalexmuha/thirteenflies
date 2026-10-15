<?php

namespace App\Support;

class ContentLocale
{
    public static function get(): string
    {
        return session('admin_locale', app()->getLocale());
    }
}
