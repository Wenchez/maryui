<div class="p-6">
    <x-card title="Catálogo de Productos" class="border-4 border-amber-600 rounded-xl shadow-md">
        @if($products->isEmpty())
            <p class="text-center text-gray-500 py-4">No hay productos disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    
                    {{-- Card de producto individual --}}
                    <x-card title="{{ $product->product_name }}" class="border-amber-600 shadow-md rounded-xl">

                        {{-- Botón editar dentro del slot menu --}}
                        <x-slot:menu>
                            <x-button 
                                icon="o-pencil-square" 
                                class="btn-circle btn-sm"
                                title="Editar producto"
                                wire:click="$dispatch('openEditProductModal', { productId: {{ $product->product_id }} })"
                            />
                        </x-slot:menu>


                        {{-- Contenido del producto --}}
                        <div class="flex flex-col items-center">
                         <img 
                            src="{{ $product->product_image ? asset('build/storage/products/' . $product->product_image) : asset('build/storage/products/default.jpeg') }}"
                            alt="{{ $product->product_name }}"
                            class="w-40 h-40 object-cover rounded-lg mb-3"
                        />

                            <p class="text-sm text-gray-500">{{ $product->productType->product_type_name ?? 'Sin tipo' }}</p>
                            <p class="text-amber-700 font-bold mt-2">${{ number_format($product->product_price, 2) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Stock: {{ $product->product_stock }}</p>
                            <p class="text-xs text-gray-500 mt-1 capitalize">Género: {{ $product->product_gender }}</p>
                        </div>

                    </x-card>

                @endforeach
            </div>
        @endif
    </x-card>
</div>
