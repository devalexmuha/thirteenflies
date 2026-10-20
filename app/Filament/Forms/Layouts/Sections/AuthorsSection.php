<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Enums\SocialNetwork;
use App\Filament\Forms\Fields\SelectFields\AuthorSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class AuthorsSection extends FormSection
{
    protected static function defaultHeading(): string
    {
        return 'Author';
    }

    protected function defaultSchema(): array
    {
        return [
            AuthorSelect::make(),
        ];
    }
}
