<?php

namespace App\Filament\Resources\Sales\Customers\Schemas;

use App\Filament\Resources\Sales\Customers\RelationManagers\OrdersRelationManager;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Njxqlus\Filament\Components\Infolists\RelationManager;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Grid::make(4)->schema([
                    TextEntry::make('userProfile.first_name')->label('First name')->placeholder('—'),
                    TextEntry::make('userProfile.last_name')->label('Last name')->placeholder('—'),
                    TextEntry::make('email'),
                    TextEntry::make('userProfile.phone')->label('Phone')->placeholder('—'),
                ]),
            ])->columnSpanFull(),
            Section::make('Addresses')
                ->collapsed()
                ->schema([
                    RepeatableEntry::make('addresses')
                        ->hiddenLabel()
                        ->columns(4)
                        ->schema([
                            TextEntry::make('full_name'),
                            TextEntry::make('phone'),
                            TextEntry::make('country'),
                            TextEntry::make('state')->placeholder('—'),
                            TextEntry::make('city'),
                            TextEntry::make('zip'),
                            TextEntry::make('address_line_1'),
                            TextEntry::make('address_line_2')->placeholder('—'),
                        ]),
                ])->columnSpanFull(),

            RelationManager::make()
                ->manager(OrdersRelationManager::class)
                ->lazy(false),

        ])->columns(1);
    }
}
