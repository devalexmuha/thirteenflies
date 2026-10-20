<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RedirectCode: int implements HasLabel
{
    case MovedPermanently = 301;
    case Found = 302;

    public function getLabel(): string
    {
        return match ($this) {
            self::MovedPermanently => '301 Moved Permanently',
            self::Found => '302 Found',
        };
    }
}
