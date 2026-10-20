<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SocialNetwork: string implements HasLabel
{
    case Website = 'website';
    case Instagram = 'instagram';
    case Facebook = 'facebook';
    case X = 'x';
    case LinkedIn = 'linkedin';
    case YouTube = 'youtube';
    case TikTok = 'tiktok';
    case Pinterest = 'pinterest';
    case Threads = 'threads';
    case Reddit = 'reddit';

    public function getLabel(): string
    {
        return match ($this) {
            self::Website => 'Website',
            self::Instagram => 'Instagram',
            self::Facebook => 'Facebook',
            self::X => 'X (Twitter)',
            self::LinkedIn => 'LinkedIn',
            self::YouTube => 'YouTube',
            self::TikTok => 'TikTok',
            self::Pinterest => 'Pinterest',
            self::Threads => 'Threads',
            self::Reddit => 'Reddit',
        };
    }
}
