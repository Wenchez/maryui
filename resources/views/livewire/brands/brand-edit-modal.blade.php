<x-modal wire:model="showModal" title="Editar Marca">
    <x-form wire:submit.prevent="update" first-error-only>
        <x-errors title="Oops!" description="Corrige los errores." icon="o-face-frown" />

        <x-input label="Nombre de la marca" wire:model.defer="brand_name" first-error-only />
        <x-input label="Descripción de la marca" wire:model.defer="brand_description" first-error-only />

        <x-slot:actions>
            <x-button label="Cancelar" class="btn-outline mr-2" wire:click="$set('showModal', false)" />
            <x-button label="Guardar cambios" class="btn-warning" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</x-modal>
