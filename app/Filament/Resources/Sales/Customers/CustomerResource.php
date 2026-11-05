<?php

namespace App\Filament\Resources\Sales\Customers;

use App\Filament\Resources\Sales\Customers\Pages\ListCustomers;
use App\Filament\Resources\Sales\Customers\Pages\ViewCustomer;
use App\Filament\Resources\Sales\Customers\Schemas\CustomerInfolist;
use App\Filament\Resources\Sales\Customers\Tables\CustomersTable;
use App\Models\Account\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'customer';

    protected static ?string $pluralModelLabel = 'customers';

    protected static ?string $recordTitleAttribute = 'email';

    public static function infolist(Schema $schema): Schema
    {
        return CustomerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
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
            'index' => ListCustomers::route('/'),
            'view' => ViewCustomer::route('/{record}'),
        ];
    }
}
