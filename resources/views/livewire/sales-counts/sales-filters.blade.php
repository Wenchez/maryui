<div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">

    {{-- Búsqueda --}}
    <x-input label="Buscar venta o vendedor" wire:model.live="search" placeholder="XB- o nombre"
        icon="o-magnifying-glass" />

    {{-- Fecha inicio --}}
    <x-datetime label="Desde" wire:model.change="from_date" type="date" icon="o-calendar" />

    {{-- Fecha fin --}}
    <x-datetime label="Hasta" wire:model.change="to_date" type="date" icon="o-calendar" />

    {{-- Limpiar --}}
    <x-button tooltip="Limpiar filtros" wire:click="clearFilters" icon="o-x-mark"
        class="font-bold btn-circle btn-error" />
</div>
