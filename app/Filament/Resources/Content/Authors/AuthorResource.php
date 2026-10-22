<?php

namespace App\Filament\Resources\Content\Authors;

use App\Filament\Resources\Content\Authors\Pages\CreateAuthor;
use App\Filament\Resources\Content\Authors\Pages\EditAuthor;
use App\Filament\Resources\Content\Authors\Pages\ListAuthors;
use App\Filament\Resources\Content\Authors\Schemas\AuthorForm;
use App\Filament\Resources\Content\Authors\Tables\AuthorsTable;
use App\Models\Content\Author;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function form(Schema $schema): Schema
    {
        return AuthorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorsTable::configure($table);
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
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }
}
