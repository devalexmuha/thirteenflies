<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Filament\Actions\SaveAction;
use App\Filament\Forms\Fields\DateFields\PublishedAtTimePicker;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\SelectFields\StatusSelect;
use Filament\Schemas\Components\Actions;

class PublishSection extends FormSection
{

    protected static function defaultHeading(): string
    {
        return 'Publish';
    }

    protected function defaultSchema(): array
    {
        return [
            StatusSelect::make()->boolean(trueLabel: 'Published', falseLabel: 'Draft'),
            PublishedAtTimePicker::make(),
        ];
    }
}
