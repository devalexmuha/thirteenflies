<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;

class ActiveColumn extends IconColumn
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable()
            ->boolean()
            ->label('Active')
            ->action(fn (Model $record) => $record->update([$this->getName() => ! $record->{$this->getName()}]));
    }
}
