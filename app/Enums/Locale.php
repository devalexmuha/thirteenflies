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

    public function flag(): string
    {
        return asset('flags/'.match ($this) {
                self::En => 'gb',
                self::Es => 'es',
                self::Uk => 'ua',
                self::Ru => 'ru',
            }.'.svg');
    }
}
