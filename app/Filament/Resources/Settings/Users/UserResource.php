<?php

namespace App\Filament\Resources\Settings\Users;

use App\Filament\Resources\Settings\Users\Pages\CreateUser;
use App\Filament\Resources\Settings\Users\Pages\EditUser;
use App\Filament\Resources\Settings\Users\Pages\ListUsers;
use App\Filament\Resources\Settings\Users\Schemas\UserForm;
use App\Filament\Resources\Settings\Users\Tables\UsersTable;
use App\Models\Account\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'admin';
    protected static ?string $pluralModelLabel = 'admins';
    protected static ?string $recordTitleAttribute = 'name';

//    /** Only admins in this list. */
//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery()->whereHas('roles', fn (Builder $q) => $q->where('name', 'admin'));
//    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
