<div class="space-y-1">
    @forelse ($saleDetails as $detail)
        <x-list-item :item="$detail" value="product_name" no-hover no-separator>
            <x-slot:avatar>
                @if ($detail['product_image'])
                    <x-avatar :image="$detail['product_image']" class="w-10 h-10" />
                @else
                    <x-avatar label="{{ strtoupper(substr($detail['product_name'], 0, 1)) }}" />
                @endif
            </x-slot:avatar>

            <x-slot:value>
                <span class="font-medium">{{ $detail['product_name'] }}</span>
            </x-slot:value>

            <x-slot:sub-value>
                <div class="text-sm text-base-content/70">
                    <span class="font-semibold">
                        ${{ number_format($detail['quantity'] * $detail['unit_price'], 2) }}
                    </span>
                </div>
            </x-slot:sub-value>

            <x-slot:actions>
                <div class="flex items-center gap-2">
                    <x-input type="text" class="w-16 text-center"
                        wire:model.debounce.500ms="saleDetails.{{ $detail['product_id'] }}.quantity"
                        wire:blur="changeQuantity({{ $detail['product_id'] }}, $event.target.value)"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'');" />




                    <x-button icon="o-trash" class="btn-ghost btn-sm text-red-500"
                        wire:click="deleteProduct({{ $detail['product_id'] }})" spinner />
                </div>
            </x-slot:actions>
        </x-list-item>
    @empty
        <p class="text-base-content text-center py-4">No hay productos en la venta</p>
    @endforelse
</div>
