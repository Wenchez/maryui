<div class="grid md:grid-cols-[1fr_400px] gap-4 p-4 w-full">

    <!-- Sección de productos -->
    <div class="min-w-0">
        <x-header title="Venta" separator>
            <x-slot:actions class="justify-center">
                <div class="flex flex-wrap justify-center items-center gap-2">
                    <livewire:sales.product-sale-filters />
                </div>
            </x-slot:actions>
        </x-header>

        <livewire:sales.products-sale-grid />
    </div>

    <!-- Panel lateral -->
    <div>
        <livewire:sales.sale-panel />
    </div>

    <livewire:sales.ticket-modal />
</div>
