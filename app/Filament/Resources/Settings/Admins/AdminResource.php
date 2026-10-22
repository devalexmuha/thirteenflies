<?php

namespace App\Filament\Resources\Settings\Admins;

use App\Filament\Resources\Settings\Admins\Pages\CreateAdmin;
use App\Filament\Resources\Settings\Admins\Pages\EditAdmin;
use App\Filament\Resources\Settings\Admins\Pages\ListAdmins;
use App\Filament\Resources\Settings\Admins\Schemas\AdminForm;
use App\Filament\Resources\Settings\Admins\Tables\AdminTable;
use App\Models\Account\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'admin';
    protected static ?string $pluralModelLabel = 'admins';


//    /** Only admins in this list. */
//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery()->whereHas('roles', fn (Builder $q) => $q->where('name', 'admin'));
//    }

    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminTable::configure($table);
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
