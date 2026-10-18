<?php

namespace App\Filament\Forms\Layouts\Sections;

use Closure;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Support\Htmlable;

abstract class FormSection extends Section
{
    abstract protected static function defaultHeading(): string;

    abstract protected function defaultSchema(): array;

    public static function make(string | array | Htmlable | Closure | null $heading = null): static
    {
        return parent::make($heading ?? static::defaultHeading());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema($this->defaultSchema());
    }

    public function append(array $components): static
    {
        return $this->schema([...$this->defaultSchema(), ...$components]);
    }

    public function prepend(array $components): static
    {
        return $this->schema([...$components, ...$this->defaultSchema()]);
    }
}
