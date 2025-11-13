<div class="w-full">
    <x-header title="Productos" separator>
        <x-slot:middle class="justify-center">
            <div class="flex flex-wrap justify-center items-center gap-2">
                <livewire:products.product-view-filters />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            <livewire:products.product-create-modal />
        </x-slot:actions>
    </x-header>

    <div class="mt-4">
        <livewire:products.products-view-grid />
    </div>

    <livewire:products.product-edit-modal />
</div>