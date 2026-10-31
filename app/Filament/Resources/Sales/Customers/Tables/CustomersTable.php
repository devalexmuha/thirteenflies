<?php

namespace App\Filament\Resources\Sales\Customers\Tables;

use App\Filament\Tables\Columns\NameColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make('userProfile.first_name')
                    ->label('First Name'),
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
