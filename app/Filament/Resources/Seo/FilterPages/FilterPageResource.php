<?php

namespace App\Filament\Resources\Seo\FilterPages;

use App\Filament\Resources\Seo\FilterPages\Pages\CreateFilterPage;
use App\Filament\Resources\Seo\FilterPages\Pages\EditFilterPage;
use App\Filament\Resources\Seo\FilterPages\Pages\ListFilterPages;
use App\Filament\Resources\Seo\FilterPages\Schemas\FilterPageForm;
use App\Filament\Resources\Seo\FilterPages\Tables\FilterPagesTable;
use App\Models\Filters\FilterPage;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilterPageResource extends Resource
{
    protected static ?string $model = FilterPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFunnel;

    protected static string|UnitEnum|null $navigationGroup = 'SEO';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return FilterPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilterPagesTable::configure($table);
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
            'index' => ListFilterPages::route('/'),
            'create' => CreateFilterPage::route('/create'),
            'edit' => EditFilterPage::route('/{record}/edit'),
        ];
    }
}
