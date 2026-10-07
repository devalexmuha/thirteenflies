<?php

namespace App\Filament\Resources\Catalog\Collections;

use App\Filament\Resources\Catalog\Collections\Pages\CreateCollection;
use App\Filament\Resources\Catalog\Collections\Pages\EditCollection;
use App\Filament\Resources\Catalog\Collections\Pages\ListCollections;
use App\Filament\Resources\Catalog\Collections\Schemas\CollectionForm;
use App\Filament\Resources\Catalog\Collections\Tables\CollectionsTable;
use App\Models\Catalog\Collection;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquare3Stack3d;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CollectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollectionsTable::configure($table);
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
            'index' => ListCollections::route('/'),
            'create' => CreateCollection::route('/create'),
            'edit' => EditCollection::route('/{record}/edit'),
        ];
    }
}
