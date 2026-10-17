<?php

namespace App\Filament\Resources\Content\Services;

use App\Filament\Resources\Content\Services\Pages\CreateService;
use App\Filament\Resources\Content\Services\Pages\EditService;
use App\Filament\Resources\Content\Services\Pages\ListServices;
use App\Filament\Resources\Content\Services\Schemas\ServiceForm;
use App\Filament\Resources\Content\Services\Tables\ServicesTable;
use App\Models\Content\Service;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;
    protected static string|UnitEnum|null $navigationGroup = 'ContentLayouts';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
