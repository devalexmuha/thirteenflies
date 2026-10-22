<?php

namespace App\Filament\Resources\Catalog\Promotions;

use App\Filament\Resources\Catalog\Promotions\Pages\CreatePromotion;
use App\Filament\Resources\Catalog\Promotions\Pages\EditPromotion;
use App\Filament\Resources\Catalog\Promotions\Pages\ListPromotions;
use App\Filament\Resources\Catalog\Promotions\Schemas\PromotionForm;
use App\Filament\Resources\Catalog\Promotions\Tables\PromotionsTable;
use App\Models\Catalog\Promotion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPercentBadge;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function form(Schema $schema): Schema
    {
        return PromotionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromotionsTable::configure($table);
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
            'index' => ListPromotions::route('/'),
            'create' => CreatePromotion::route('/create'),
            'edit' => EditPromotion::route('/{record}/edit'),
        ];
    }
}
