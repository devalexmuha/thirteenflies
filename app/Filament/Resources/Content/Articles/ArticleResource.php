<?php

namespace App\Filament\Resources\Content\Articles;

use App\Filament\Resources\Content\Articles\Pages\CreateArticle;
use App\Filament\Resources\Content\Articles\Pages\EditArticle;
use App\Filament\Resources\Content\Articles\Pages\ListArticles;
use App\Filament\Resources\Content\Articles\Schemas\ArticleForm;
use App\Filament\Resources\Content\Articles\Tables\ArticlesTable;
use App\Models\Content\Article;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function form(Schema $schema): Schema
    {
        return ArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArticlesTable::configure($table);
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
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
