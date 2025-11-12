<x-modal wire:model="showModal" title="Eliminar Producto">
    <div class="text-center py-4">
        <x-icon name="o-exclamation-circle" class="w-12 h-12 mx-auto text-warning" />
        <p class="mt-4 text-lg">
            ¿Estás seguro que deseas eliminar el producto
            <span class="font-bold">{{ $productName }}</span>?
        </p>
        <p class="text-sm mt-2">
            Esta acción no se puede deshacer.
        </p>

        @if ($errorMessage)
            <p class="text-red-600 mt-4 text-sm font-semibold">
                {{ $errorMessage }}
            </p>
        @endif
    </div>

    <x-slot:actions>
        <x-button label="Cancelar" class="btn-outline mr-2" wire:click="$set('showModal', false)" />
        <x-button label="Eliminar" class="btn-error" wire:click="delete" spinner="delete" />
    </x-slot:actions>
</x-modal>
