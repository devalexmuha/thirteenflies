<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;

enum OrderStatus: string implements HasColor
{
    case Pending = 'pending';
    case Received = 'received';
    case Processing = 'processing';
    case Delivery = 'delivery';
    case Delivered = 'delivered';
    case Complete = 'complete';
    case Canceled = 'canceled';

    public function getColor(): string|array
    {
        return match ($this) {
            self::Pending => 'danger',
            self::Received, self::Processing => Color::Blue,
            self::Delivery => Color::Orange,
            self::Delivered, self::Complete => 'success',
            self::Canceled => 'gray',
        };
    }
}
