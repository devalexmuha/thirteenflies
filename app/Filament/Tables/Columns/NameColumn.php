<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class NameColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'name';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable()
             ->searchable(query: fn (Builder $query, string $search): Builder => $query
                 ->whereRaw(
                     "LOWER(CAST({$this->getName()} AS CHAR)) LIKE ?",
                     ['%' . mb_strtolower($search) . '%'],
                 ));
    }
}
