<x-modal wire:model="showModal" title="Editar Producto" box-class="max-w-2xl">
    <x-form wire:submit.prevent="update" first-error-only>
        <x-errors title="Ups!" description="Corrige los errores." icon="o-face-frown" />

        <div class="flex flex-col w-full">

            <div class="flex flex-col md:flex-row gap-6 w-full">

                {{-- === CONTENEDOR DE IMAGEN == --}}
                <div class="flex flex-col items-center justify-center w-full md:w-auto flex-1 md:flex-none">

                    {{-- Si se selecciona UNA nueva imagen --}}
                    @if ($product_image)
                        <img src="{{ $product_image->temporaryUrl() }}"
                            class="rounded-xl border shadow w-60 h-60 object-cover mb-3 transition">

                        {{-- Quitar imagen NUEVA y volver a la original --}}
                        <x-button type="button" wire:click="$set('product_image', null)"
                            class="px-3 py-1 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 active:scale-95 transition">
                            Quitar imagen
                        </x-button>

                        {{-- Si NO hay nueva, muestra la imagen actual --}}
                    @else
                        <img src="{{ $current_image_url }}"
                            class="rounded-xl border shadow w-60 h-60 object-cover mb-3">

                        <input id="product_image" type="file" wire:model="product_image" accept="image/*" class="hidden" wire:key="{{ $productId }}-image">

                        {{-- Botón dispara click en input --}}
                        <x-button type="button"
                            onclick="document.getElementById('product_image').click(); return false;"
                            wire:loading.attr="disabled" wire:target="product_image"
                            class="bg-blue-600! text-white! hover:bg-blue-700! transition-transform hover:scale-105 active:scale-95 px-5">

                            <span wire:loading.remove wire:target="product_image">Cambiar imagen</span>

                            <span wire:loading wire:target="product_image" class="flex items-center gap-2">
                                <span class="loading loading-spinner loading-sm"></span> Cargando...
                            </span>
                        </x-button>

                        @error('product_image')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    @endif
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
                        option-value="product_type_id" option-label="product_type_name" placeholder="Seleccione un tipo"
                        class="w-full!" />
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
            <x-button label="Guardar Cambios" class="btn-warning" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</x-modal>
