<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Enums\SocialNetwork;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SocialsSection extends FormSection
{
    protected static function defaultHeading(): string
    {
        return 'Social Media';
    }

    protected function defaultSchema(): array
    {
        return [
            Repeater::make('socials')
                    ->hiddenLabel()
                    ->schema([
                        Select::make('network')
                              ->options(SocialNetwork::class)
                              ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                              ->required(),
                        TextInput::make('url')
                                 ->label('Profile link')
                                 ->url()
                                 ->required(),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Add social link'),
        ];
    }
}
