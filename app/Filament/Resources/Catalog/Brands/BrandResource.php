<?php

namespace App\Filament\Resources\Catalog\Brands;

use App\Filament\Resources\Catalog\Brands\Pages\CreateBrand;
use App\Filament\Resources\Catalog\Brands\Pages\EditBrand;
use App\Filament\Resources\Catalog\Brands\Pages\ListBrands;
use App\Filament\Resources\Catalog\Brands\Schemas\BrandForm;
use App\Filament\Resources\Catalog\Brands\Tables\BrandsTable;
use App\Models\Catalog\Brand;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BrandForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandsTable::configure($table);
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
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }
}
