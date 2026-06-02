<x-dynamic-component
    :component="static::isSimple() ? 'filament-panels::page.simple' : 'filament-panels::page'"
>
    <x-filament-panels::form
        wire:submit="save"
    >
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="[
                \Filament\Forms\Components\Actions\Action::make('save')
                    ->label('Update')
                    ->submit()
            ]"
        />
    </x-filament-panels::form>
</x-dynamic-component>
