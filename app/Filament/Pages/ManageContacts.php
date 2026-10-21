<?php

namespace App\Filament\Pages;

use App\Enums\Locale;
use App\Filament\Forms\Fields\ImageFields\IconPicker;
use App\Settings\ContactSettings;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageContacts extends SettingsPage
{
    protected static string $settings = ContactSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Contacts';
    protected static ?int $navigationSort = 2;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()
                ->tabs([
                    Tab::make('Contacts')->schema([
                        TextInput::make('phone')->tel(),
                        TextInput::make('email')->email(),
                    ]),

                    Tab::make('Addresses')->schema([
                        Repeater::make('addresses')
                                ->hiddenLabel()
                                ->schema([
                                    Tabs::make()->tabs(self::localeTabs()),
                                    Textarea::make("working_hours")->label('Working hours')->rows(2)->placeholder('Mon–Fri 9am–6pm'),
                                    TextInput::make('map_link')->url()->columnSpanFull(),
                                    TextInput::make('latitude')->numeric(),
                                    TextInput::make('longitude')->numeric(),
                                ])
                                ->columns(1)
                                ->collapsible()
                                ->addActionLabel('Add address'),
                    ]),

                    Tab::make('Social Networks')->schema([
                        Repeater::make('socials')
                                ->hiddenLabel()
                                ->schema([
                                    TextInput::make('link')->url()->required(),
                                    IconPicker::make()->columnSpan(1)->extraAttributes(['class' => 'single-image-picker']),
                                ])
                                ->columns(2)
                                ->addActionLabel('Add social network'),
                    ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    private static function localeTabs(): array
    {
        return collect(Locale::cases())
            ->map(fn(Locale $locale) => Tab::make(strtoupper($locale->value))->schema([
                Textarea::make("address.{$locale->value}")
                        ->label('Address')
                        ->rows(2)
                        ->required($locale === Locale::En),
            ]))
            ->all();
    }
}
