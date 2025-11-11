<div>
    <x-button icon="o-plus" class="btn-success" wire:click="open">
        Nuevo producto
    </x-button>

    <x-modal wire:model="showModal" title="Nuevo Producto" box-class="max-w-2xl">
        <x-form wire:submit.prevent="store" first-error-only>
            <x-errors title="Ups!" description="Corrige los errores." icon="o-face-frown" />

            <div class="flex flex-col w-full">

                <div class="flex flex-col md:flex-row gap-6 w-full">

                    <div class="flex items-center justify-center w-full md:w-auto flex-1 md:flex-none">
                        <x-file wire:model="product_image" accept="image/*" label="Foto" crop-after-change>
    <img src="{{ $product_image ? $product_image->temporaryUrl() : asset('build/storage/products/default.jpeg') }}"
        class="h-90 w-90 rounded-xl object-cover border" />
</x-file>
                    </div>

                    <div class="flex flex-col gap-1 w-full flex-1">

                        <x-input label="Nombre del producto" wire:model.defer="product_name" placeholder="Nombre"
                            class="w-full" />

                        <div class="flex gap-4 w-full">
                            <x-input type="number" label="Cantidad" wire:model.defer="product_stock" min="0"
                                step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="flex-1 w-full" />
                            <x-input type="text" step="0.01" label="Precio" icon="o-currency-dollar"
                                wire:model.defer="product_price" min="0" money class="flex-1 w-full" />
                        </div>

                        <x-select label="Marca" wire:model="brand_id" :options="$brands" option-value="brand_id"
                            option-label="brand_name" placeholder="Seleccione una marca" class="w-full!" />
                        <x-select label="Tipo de producto" wire:model="product_type_id" :options="$types"
                            option-value="product_type_id" option-label="product_type_name"
                            placeholder="Seleccione un tipo" class="w-full!" />
                        <x-select label="Género" wire:model="product_gender" :options="[
                            ['id' => 'unisex', 'name' => 'Unisex'],
                            ['id' => 'male', 'name' => 'Masculino'],
                            ['id' => 'female', 'name' => 'Femenino'],
                        ]" option-value="id"
                            option-label="name" class="w-full!" />
                    </div>

                </div>
            </div>

            <x-slot:actions>
                <x-button label="Cancelar" class="btn-outline mr-2" wire:click="$set('showModal', false)" />
                <x-button label="Crear" class="btn-success" type="submit" spinner="update" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
