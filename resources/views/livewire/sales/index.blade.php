<div class="flex gap-4 p-4 h-screen">
    <div class="flex-1 overflow-y-visible shrink-0">
        <x-header title="Productos" separator>
            <x-slot:actions class="justify-center">
                <div class="flex flex-wrap justify-center items-center gap-2">
                    <livewire:sales.product-sale-filters />
                </div>
            </x-slot:actions>
        </x-header>
        <livewire:sales.products-sale-grid />
    </div>

    <div class="w-90">
        <livewire:sales.sale-panel />
    </div>
    <livewire:sales.ticket-modal />
</div>
