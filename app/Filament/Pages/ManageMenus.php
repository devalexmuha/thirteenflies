<?php

namespace App\Filament\Pages;

use App\Settings\MenuSettings;
use BackedEnum;
use Filament\Pages\SettingsPage;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageMenus extends SettingsPage
{
    protected static string $settings = MenuSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Menu Builder';
    protected static ?int $navigationSort = 3;
}
