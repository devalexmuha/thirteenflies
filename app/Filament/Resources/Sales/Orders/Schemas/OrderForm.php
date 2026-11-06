<?php

namespace App\Filament\Resources\Sales\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Filament\Resources\Sales\Orders\RelationManagers\OrderItemsRelationManager;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Njxqlus\Filament\Components\Infolists\RelationManager;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Grid::make(4)->schema([
                    TextEntry::make('number'),
                    TextEntry::make('email')->label('Email address'),
                    TextEntry::make('payment_status')->badge(),
                    Select::make('status')->options(OrderStatus::class)->selectablePlaceholder(false)->required(),
                ]),
            ]),

            Section::make('Details')
                ->collapsed(false)
                ->schema([
                    Grid::make(4)->schema([
                        TextEntry::make('subtotal')->money('USD', divideBy: 100),
                        TextEntry::make('shipping_total')->money('USD', divideBy: 100),
                        TextEntry::make('tax_total')->money('USD', divideBy: 100),
                        TextEntry::make('total')->money('USD', divideBy: 100),
                        TextEntry::make('currency'),
                        TextEntry::make('locale'),
                        TextEntry::make('paid_at')->dateTime()->placeholder('—'),
                        TextEntry::make('canceled_at')->dateTime()->placeholder('—'),
                    ]),
                    TextEntry::make('customer_note')->placeholder('—')->columnSpanFull(),
                ]),

            Section::make('Shipping address')
                ->collapsed(false)
                ->schema([
                    Grid::make(4)->schema(array_map(
                        fn (string $field) => TextEntry::make("shipping_address.{$field}")->placeholder('—'),
                        ['full_name', 'phone', 'country', 'state', 'city', 'zip', 'address_line_1', 'address_line_2'],
                    )),
                ]),

            RelationManager::make()
                ->manager(OrderItemsRelationManager::class)
                ->lazy(false),
        ])->columns(1);
    }
}
