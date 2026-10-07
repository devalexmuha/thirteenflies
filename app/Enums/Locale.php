<?php

namespace App\Enums;

enum Locale: string
{
    case En = 'en';
    case Es = 'es';
    case Uk = 'uk';
    case Ru = 'ru';

    public function label(): string
    {
        return match ($this) {
            self::En => 'English',
            self::Es => 'Spanish',
            self::Uk => 'Ukrainian',
            self::Ru => 'Russian',
        };
    }
}
