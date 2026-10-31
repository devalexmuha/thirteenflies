<?php

namespace App\Filament\Pages;

use App\Settings\SeoSettings;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageRobots extends SettingsPage
{
    protected static string $settings = SeoSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'SEO';

    protected static ?string $navigationLabel = 'Robots.txt';

    protected static ?string $title = 'Robots.txt';

    protected static ?string $slug = 'robots-txt';

    protected static ?int $navigationSort = 4;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('robots_txt')
                ->hiddenLabel()
                ->required()
                ->rows(25)
                ->extraInputAttributes(['class' => 'font-mono'])
                ->columnSpanFull(),
        ]);
    }
}
