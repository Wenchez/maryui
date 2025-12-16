<x-collapse wire:model="open" separator class="bg-base-200 rounded-lg mb-4">

    {{-- Heading --}}
    <x-slot:heading>
        <div class="flex items-center gap-2">
            <x-icon name="o-funnel" class="w-4 h-4" />
            <span class="font-semibold">Filtros de búsqueda</span>
        </div>
    </x-slot:heading>

    {{-- Content --}}
    <x-slot:content>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-end">

            {{-- Fecha inicio --}}
            <x-datetime label="Desde" wire:model.change="from_date" type="date" icon="o-calendar" />

            {{-- Fecha fin --}}
            <x-datetime label="Hasta" wire:model.change="to_date" type="date" icon="o-calendar" />

            {{-- Limpiar --}}
            <x-button tooltip="Limpiar filtros" wire:click="clearFilters" icon="o-x-mark"
                class="font-bold btn-circle btn-error" />
        </div>

    </x-slot:content>
</x-collapse>
