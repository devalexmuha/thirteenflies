<?php

namespace App\Filament\Resources\Content\Articles\Pages;

use App\Filament\Resources\Content\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
