<?php

namespace App\Filament\Resources\Seo\Redirects;

use App\Filament\Resources\Seo\Redirects\Pages\CreateRedirect;
use App\Filament\Resources\Seo\Redirects\Pages\EditRedirect;
use App\Filament\Resources\Seo\Redirects\Pages\ListRedirects;
use App\Filament\Resources\Seo\Redirects\Schemas\RedirectForm;
use App\Filament\Resources\Seo\Redirects\Tables\RedirectsTable;
use App\Models\Seo\Redirect;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;
    protected static string|UnitEnum|null $navigationGroup = 'SEO';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return RedirectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectsTable::configure($table);
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
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
