<div class="flex flex-col w-90 bg-white rounded-lg shadow p-4">
    <h2 class="text-lg font-bold mb-2">Venta activa</h2>

    <livewire:sales.sale-detail-list wire:key="sale-detail-list" />

    <x-hr />

    <livewire:sales.sale-summary 
        :subtotal="$subtotal"
        :tax="$tax"
        :total="$total"
        wire:key="sale-summary"
    />
</div>
