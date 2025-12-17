<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-end">

    {{-- Fecha inicio --}}
    <x-datepicker label="Desde" wire:model.live="from_date" icon="o-calendar" :config="$dateConfig" />

    {{-- Fecha fin --}}
    <x-datepicker label="Hasta" wire:model.live="to_date" icon="o-calendar" :config="$dateConfig" />

    {{-- Limpiar --}}
    <x-button tooltip="Limpiar filtros" wire:click="clearFilters" icon="o-x-mark" class="font-bold btn-circle btn-error" />
</div>
