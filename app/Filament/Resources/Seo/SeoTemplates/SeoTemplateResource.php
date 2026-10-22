<?php

namespace App\Filament\Resources\Seo\SeoTemplates;

use App\Filament\Resources\Seo\SeoTemplates\Pages\EditSeoTemplate;
use App\Filament\Resources\Seo\SeoTemplates\Pages\ListSeoTemplates;
use App\Filament\Resources\Seo\SeoTemplates\Schemas\SeoTemplateForm;
use App\Filament\Resources\Seo\SeoTemplates\Tables\SeoTemplatesTable;
use App\Models\Seo\SeoTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class SeoTemplateResource extends Resource
{
    protected static ?string $model = SeoTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static string|UnitEnum|null $navigationGroup = 'SEO';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SeoTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeoTemplates::route('/'),
            'edit' => EditSeoTemplate::route('/{record}/edit'),
        ];
    }
}
