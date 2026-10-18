<?php

namespace App\Filament\Forms\Fields\TextFields;

use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

/**
 * SlugInput::make()  — lives on slugs, so put it inside SlugGroup.
 * Unique per locale + model type. Slugified when the field loses focus.
 */
class SlugInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'slug';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->required()
             ->live(onBlur: true)
             ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug((string) $state, '-', ContentLocale::get())))
             ->unique(
                 table: Slug::class,
                 column: 'slug',
                 ignoreRecord: true,
                 modifyRuleUsing: fn (Unique $rule, $livewire) => $rule
                     ->where('locale', ContentLocale::get())
                     ->where('sluggable_type', $livewire->getModel()),
             );
    }
}
