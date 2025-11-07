<x-modal wire:model="showModal" title="Editar Categoría">
    <x-form wire:submit.prevent="update" first-error-only>
        <x-errors title="Oops!" description="Corrige los errores." icon="o-face-frown" />

        <x-input label="Nombre de la categoría" wire:model.defer="product_type_name" first-error-only />
        <x-input label="Descripción de la categoría" wire:model.defer="product_type_description" first-error-only />

        <x-slot:actions>
            <x-button label="Guardar cambios" class="btn-primary w-full" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</x-modal>
