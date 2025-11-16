<div class="flex gap-2 items-center flex-wrap p-2">
    <x-input type="text" icon="o-magnifying-glass" wire:model.live="search" placeholder="Buscar" placeholder="Buscar"
        clearable />

    <x-dropdown label="Marcas">
        <x-menu-item title="Limpiar" wire:click="clearBrands" icon="o-x-mark" class="font-bold" />
        <x-menu-separator />
        @foreach ($availableBrands as $id => $name)
            <x-menu-item @click.stop="">
                <x-checkbox label="{{ $name }}" wire:model="selectedBrands" value="{{ $id }}"
                    wire:change="sendFilters" />
            </x-menu-item>
        @endforeach
    </x-dropdown>

    <x-dropdown label="Categorías">
        <x-menu-item title="Limpiar" wire:click="clearTypes" icon="o-x-mark" class="font-bold" />
        <x-menu-separator />
        @foreach ($availableTypes as $id => $name)
            <x-menu-item @click.stop="">
                <x-checkbox label="{{ $name }}" wire:model="selectedTypes" value="{{ $id }}"
                    wire:change="sendFilters" />
            </x-menu-item>
        @endforeach
    </x-dropdown>

    <x-dropdown label="Género">
        <x-menu-item title="Limpiar" wire:click="clearGenders" icon="o-x-mark" class="font-bold" />
        <x-menu-separator />
        @foreach ($availableGenders as $key => $label)
            <x-menu-item @click.stop="">
                <x-checkbox label="{{ $label }}" wire:model="selectedGenders" value="{{ $key }}"
                    wire:change="sendFilters" />
            </x-menu-item>
        @endforeach
    </x-dropdown>

    <x-button tooltip="Limpiar filtros" wire:click="clearFilters" icon="o-x-mark"
        class="font-bold btn-circle btn-error" />
</div>
