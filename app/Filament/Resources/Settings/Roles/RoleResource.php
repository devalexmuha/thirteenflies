<?php

namespace App\Filament\Resources\Settings\Roles;

use App\Filament\Resources\Settings\Roles\Pages\CreateRole;
use App\Filament\Resources\Settings\Roles\Pages\EditRole;
use App\Filament\Resources\Settings\Roles\Pages\ListRoles;
use App\Filament\Resources\Settings\Roles\Schemas\RoleForm;
use App\Filament\Resources\Settings\Roles\Tables\RolesTable;
use App\Models\Access\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $navigationParentItem = 'Admins';

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
