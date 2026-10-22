<?php

namespace App\Filament\RelationManagers;

use App\Filament\Tables\Columns\RelationNameColumn;
use App\Models\Filters\Attribute;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FilterAttributesRelationManager extends RelationManager
{
    protected static string $relationship = 'filterAttributes';

    protected static ?string $title = 'Attributes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Attribute::query())
            ->recordTitleAttribute('name')
            ->columns([
                RelationNameColumn::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->fillForm(fn (Attribute $record): array => $record->attributesToArray())
                    ->using(fn (Attribute $record, array $data) => $record->update($data)),
                Action::make('attach')
                    ->icon('heroicon-m-link')
                    ->color('success')
                    ->hidden(fn (Attribute $record): bool => $this->isAttached($record))
                    ->action(fn (Attribute $record) => $this->getOwnerRecord()->filterAttributes()->attach($record)),
                Action::make('detach')
                    ->icon('heroicon-m-link-slash')
                    ->color('danger')
                    ->visible(fn (Attribute $record): bool => $this->isAttached($record))
                    ->action(fn (Attribute $record) => $this->getOwnerRecord()->filterAttributes()->detach($record)),
                DeleteAction::make(),
            ]);
    }

    protected function resolveTableRecord(?string $key): ?Model
    {
        return Attribute::find($key);
    }

    protected function isAttached(Attribute $record): bool
    {
        return $this->getOwnerRecord()->filterAttributes()->whereKey($record->getKey())->exists();
    }
}
