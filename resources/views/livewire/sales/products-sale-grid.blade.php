<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 my-8 px-2">
    @foreach($products as $product)
        <livewire:sales.product-sale-card 
            :product="$product" 
            wire:key="product-{{ $product->product_id }}" 
        />
    @endforeach
</div>
