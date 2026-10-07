<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Pages;

use App\Filament\Resources\Catalog\FilterAttributes\FilterAttributeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFilterAttribute extends CreateRecord
{
    protected static string $resource = FilterAttributeResource::class;
}
