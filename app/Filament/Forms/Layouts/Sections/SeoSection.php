<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Filament\Actions\SaveAction;
use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\FieldGroups\SlugGroup;
use App\Filament\Forms\Fields\DateFields\PublishedAtTimePicker;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\SelectFields\RobotsSelect;
use App\Filament\Forms\Fields\SelectFields\StatusSelect;
use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use App\Filament\Forms\Fields\TextFields\SlugInput;
use Filament\Schemas\Components\Actions;

class SeoSection extends FormSection
{

    protected static function defaultHeading(): string
    {
        return 'SEO';
    }

    protected function defaultSchema(): array
    {
        return [
            SeoMetaGroup::make([MetaTitleInput::make()]),
            SlugGroup::make([SlugInput::make()]),
            SeoMetaGroup::make([MetaDescriptionTextarea::make(), RobotsSelect::make()])
        ];
    }
}
