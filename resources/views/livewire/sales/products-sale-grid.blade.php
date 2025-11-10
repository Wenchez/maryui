<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 my-8 px-2 min-h-[60vh]">
    @forelse ($products as $product)
        <livewire:sales.product-sale-card 
            :product="$product" 
            wire:key="product-{{ $product->product_id }}" 
        />
    @empty
        <div class="col-span-full flex flex-col items-center justify-center py-20 text-gray-500">
            <x-icon name="o-face-frown" class="w-16 h-16 text-warning" />
            <h2 class="mt-4 text-lg font-bold text-gray-700">No hay productos disponibles</h2>
            <p class="text-sm text-gray-500">Prueba con otros filtros o revisa el inventario.</p>
        </div>
    @endforelse
</div>

