<?php

namespace App\Filament\Tables\Columns;

use Illuminate\Database\Eloquent\Model;

class RelationNameColumn extends NameColumn
{
    /**
     * Link each record's name to its page in the given Filament resource.
     *
     * @param  class-string  $resource
     */
    public function linkToResource(string $resource, string $page = 'edit'): static
    {
        return $this->url(fn (Model $record): string => $resource::getUrl($page, ['record' => $record]));
    }
}
