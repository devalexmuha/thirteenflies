<?php

namespace App\Filament\Schemas\Fields;

use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class SlugField
{
    public static function make(): Group
    {

        return Group::make()
                    ->relationship('slug')
                    ->schema([
                        TextInput::make('slug')
                                 ->live(onBlur: true)
                                 ->afterStateUpdated(fn($state, $set) => $set('slug',
                                     Str::slug($state, '-', ContentLocale::get())))
                                 ->unique(
                                     table: Slug::class,
                                     column: 'slug',
                                     ignoreRecord: true,
                                     modifyRuleUsing: fn(Unique $rule, $livewire) => $rule
                                         ->where('locale', ContentLocale::get())
                                         ->where('sluggable_type', $livewire->getModel()),
                                 )->required(),
                    ]);

    }
}
