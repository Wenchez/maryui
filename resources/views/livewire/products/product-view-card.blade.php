<div class="hover:scale-105 transition-transform">
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
            <img src="{{ $product->product_image_url }}" class="w-full h-60 object-cover rounded" />
        </x-slot:figure>

        <x-slot:menu>
            <x-button icon="o-pencil" tooltip="Editar" class="btn-warning btn-circle btn-sm"
                wire:click="$dispatch('editModal', [{{ $product->product_id }}])" />
        </x-slot:menu>
    </x-card>
</div>