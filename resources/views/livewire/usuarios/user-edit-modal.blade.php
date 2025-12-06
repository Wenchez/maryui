<x-modal wire:model="showModal" title="Editar Usuario">
    <x-form wire:submit.prevent="update" first-error-only>
        <x-errors title="Oops!" description="Corrige los errores." icon="o-face-frown" />

        <x-input label="Nombre completo" wire:model.defer="name" first-error-only />
        <x-input label="Correo electrónico" wire:model.defer="email" type="email" first-error-only />

        <x-select 
            label="Rol" 
            wire:model.defer="role" 
            :options="[
                ['value' => 'manager', 'label' => 'Gerente'],
                ['value' => 'cashier', 'label' => 'Cajero'],
            ]"
            option-value="value"
            option-label="label"
            placeholder="Selecciona un rol" 
            first-error-only 
        />

        <x-slot:actions>
            <x-button label="Cancelar" class="btn-outline mr-2" wire:click="$set('showModal', false)" />
            <x-button label="Guardar cambios" class="btn-warning" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</x-modal>
