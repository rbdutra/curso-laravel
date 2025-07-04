<x-filament-panels::page>

    <x-filament-panels::form wire:submit="enviar">

        {{ $this->reportForm }}

        <x-filament-panels::form.actions :actions="$this->getFormActions()"/>
    </x-filament-panels::form>

</x-filament-panels::page>
