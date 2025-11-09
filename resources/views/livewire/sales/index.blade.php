<div class="flex gap-4 p-4 h-screen">
    <!-- Panel izquierdo: productos -->
    <div class="flex-1 overflow-y-auto">
        <livewire:sales.product-sale-filters />
        <div wire:loading wire:target="products-sale-grid">
            <x-progress class="progress-primary h-0.5 my-4" indeterminate />
        </div>
        <livewire:sales.products-sale-grid />
    </div>

    <!-- Panel derecho: venta activa -->
    <div class="w-90 bg-white rounded shadow p-4 flex flex-col">
        Panel de ventas
        <!-- <livewire:sales.sale-panel /> -->
    </div>
</div>
