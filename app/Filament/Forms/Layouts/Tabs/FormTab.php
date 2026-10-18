<?php

namespace App\Filament\Forms\Layouts\Tabs;

use Closure;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Support\Htmlable;

abstract class FormTab extends Tab
{
    abstract protected static function defaultLabel(): string;

    abstract protected function defaultSchema(): array;

    public static function make(string | Htmlable | Closure | null $label = null): static
    {
        return parent::make($label ?? static::defaultLabel());
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
}
