<?php

namespace App\Filament\Resources\Catalog\FilterAttributes;

use App\Filament\Resources\Catalog\FilterAttributes\Pages\CreateFilterAttribute;
use App\Filament\Resources\Catalog\FilterAttributes\Pages\EditFilterAttribute;
use App\Filament\Resources\Catalog\FilterAttributes\Pages\ListFilterAttributes;
use App\Filament\Resources\Catalog\FilterAttributes\Schemas\FilterAttributeForm;
use App\Filament\Resources\Catalog\FilterAttributes\Tables\FilterAttributesTable;
use App\Models\Filters\Attribute;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilterAttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationLabel = 'Filter Attributes';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';
    protected static ?string $navigationParentItem = 'Products';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FilterAttributeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilterAttributesTable::configure($table);
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
            'index' => ListFilterAttributes::route('/'),
            'create' => CreateFilterAttribute::route('/create'),
            'edit' => EditFilterAttribute::route('/{record}/edit'),
        ];
    }
}
