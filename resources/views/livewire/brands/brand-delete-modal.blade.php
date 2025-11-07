<x-modal wire:model="showModal" title="Eliminar Marca">
    <div class="text-center py-4">
        <x-icon name="o-exclamation-circle" class="w-12 h-12 mx-auto text-warning" />
        <p class="mt-4 text-lg">
            ¿Estás seguro que deseas eliminar la marca
            <span class="font-bold">{{ $brandName }}</span>?
        </p>
        <p class="text-sm mt-2">
            Esta acción no se puede deshacer.
        </p>
    </div>

    <x-slot:actions>
        <x-button label="Cancelar" class="btn-outline mr-2" wire:click="$set('showModal', false)" />
        <x-button label="Eliminar" class="btn-error" wire:click="delete" spinner="delete" />
    </x-slot:actions>
</x-modal>
