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

    protected array $prepended = [];
    protected array $appended = [];

    public function prepend(array $components): static
    {
        $this->prepended = [...$this->prepended, ...$components];

        return $this->rebuildSchema();
    }

    public function append(array $components): static
    {
        $this->appended = [...$this->appended, ...$components];

        return $this->rebuildSchema();
    }

    private function rebuildSchema(): static
    {
        return $this->schema([...$this->prepended, ...$this->defaultSchema(), ...$this->appended]);
    }
}
