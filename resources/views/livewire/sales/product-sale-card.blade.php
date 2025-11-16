<div wire:click="addProductToSale" class="cursor-pointer hover:scale-105 transition-transform">
    <x-card shadow>
        <x-slot:title>
            <div class="w-full min-w-0">
                <span class="block w-full overflow-hidden whitespace-nowrap text-ellipsis text-base font-medium"
                    style="text-overflow: ellipsis;">
                    {{ $product->product_name }}
                </span>
            </div>
        </x-slot:title>

        <div class="text-lg font-semibold text-center">
            {{ $product->formatted_price }}
        </div>

        <x-slot:figure>
            <img src="{{ $product->product_image_url }}" class="w-full h-80 object-cover rounded" tooltip="Agregar" />
        </x-slot:figure>
    </x-card>
</div>