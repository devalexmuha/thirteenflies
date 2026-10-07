<?php

namespace App\Filament\Resources\Catalog\FilterAttributeValues;

use App\Filament\Resources\Catalog\FilterAttributeValues\Pages\CreateFilterAttributeValue;
use App\Filament\Resources\Catalog\FilterAttributeValues\Pages\EditFilterAttributeValue;
use App\Filament\Resources\Catalog\FilterAttributeValues\Pages\ListFilterAttributeValues;
use App\Filament\Resources\Catalog\FilterAttributeValues\Schemas\FilterAttributeValueForm;
use App\Filament\Resources\Catalog\FilterAttributeValues\Tables\FilterAttributeValuesTable;
use App\Models\Filters\AttributeValue;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilterAttributeValueResource extends Resource
{
    protected static ?string $model = AttributeValue::class;

    protected static ?string $navigationLabel = 'Filter Values';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';
    protected static ?string $navigationParentItem = 'Products';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FilterAttributeValueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilterAttributeValuesTable::configure($table);
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
            'index' => ListFilterAttributeValues::route('/'),
            'create' => CreateFilterAttributeValue::route('/create'),
            'edit' => EditFilterAttributeValue::route('/{record}/edit'),
        ];
    }
}
