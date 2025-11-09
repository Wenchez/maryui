<div wire:click="addProductToSale" class="cursor-pointer">
    <x-card 
        :title="$product->product_name" 
        :subtitle="$product->formatted_price" 
        shadow
        class="border-2"
    >
        <x-slot:figure>
            <img src="{{ $product->product_image_url }}" class="w-full h-80 object-cover rounded" />
        </x-slot:figure>
    </x-card>
</div>