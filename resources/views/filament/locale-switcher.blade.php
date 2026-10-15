@php($current = \App\Enums\Locale::from(App\Support\ContentLocale::get()))

<div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
    <x-filament::dropdown placement="bottom-end">
        <x-slot name="trigger">
            <button type="button" @click="open = !open" class="flex items-center gap-1.5 px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-200">
                <img src="{{ $current->flag() }}" alt="" class="h-3.5 w-5 rounded-sm object-cover">
                <span>{{ strtoupper($current->value) }}</span>
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            @foreach (\App\Enums\Locale::cases() as $locale)
                <x-filament::dropdown.list.item tag="a" :href="route('filament.admin.locale', $locale->value)">
                    <span class="flex w-full items-center gap-2">
                        <img src="{{ $locale->flag() }}" alt="" class="h-3.5 w-5 rounded-sm object-cover">
                        <span>{{ strtoupper($locale->value) }}</span>
                        @if ($locale === $current)
                            <x-filament::icon icon="heroicon-m-check" class="ms-auto h-4 w-4 text-primary-600" />
                        @endif
                    </span>
                </x-filament::dropdown.list.item>
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>
