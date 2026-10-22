<?php

namespace App\Filament\Resources\Catalog\Discounts;

use App\Filament\Resources\Catalog\Discounts\Pages\CreateDiscount;
use App\Filament\Resources\Catalog\Discounts\Pages\EditDiscount;
use App\Filament\Resources\Catalog\Discounts\Pages\ListDiscounts;
use App\Filament\Resources\Catalog\Discounts\Schemas\DiscountForm;
use App\Filament\Resources\Catalog\Discounts\Tables\DiscountsTable;
use App\Models\Catalog\Discount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';

    protected static ?string $navigationParentItem = 'Products';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function form(Schema $schema): Schema
    {
        return DiscountForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiscountsTable::configure($table);
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
            'index' => ListDiscounts::route('/'),
            'create' => CreateDiscount::route('/create'),
            'edit' => EditDiscount::route('/{record}/edit'),
        ];
    }
}
