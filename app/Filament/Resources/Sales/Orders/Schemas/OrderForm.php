<?php

namespace App\Filament\Resources\Sales\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'id'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('status')
                    ->options(OrderStatus::class)
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options(PaymentStatus::class)
                    ->default('unpaid')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('shipping_total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('tax_total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('usd'),
                TextInput::make('locale')
                    ->required()
                    ->default('en'),
                TextInput::make('shipping_address')
                    ->required(),
                Textarea::make('customer_note')
                    ->columnSpanFull(),
                DateTimePicker::make('paid_at'),
                DateTimePicker::make('canceled_at'),
            ]);
    }
}
