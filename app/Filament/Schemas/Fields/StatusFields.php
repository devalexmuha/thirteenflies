<?php

namespace App\Filament\Schemas\Fields;

use Filament\Forms\Components\Toggle;
use InvalidArgumentException;

class StatusFields
{

    public static function make(array $fields): array
    {
        $result = [];

        foreach ($fields as $field) {
            if ($field === 'make' || ! method_exists(self::class, $field)) {
                throw new InvalidArgumentException("Unknown status field: {$field}");
            }

            $result[] = self::$field();
        }

        return $result;
    }

    private static function isActive(): Toggle
    {
        return Toggle::make('is_active')
                     ->label('Active')
                     ->default(true);
    }

    private static function isFeatured(): Toggle
    {
        return Toggle::make('is_featured')
                     ->label('Featured')
                     ->default(false);
    }
}
