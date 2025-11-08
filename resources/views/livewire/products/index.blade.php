<div class="w-full">
    <x-header title="Productos" separator>
        <x-slot:actions>
            <livewire:products.product-create-modal />
        </x-slot:actions>
    </x-header>

    <div class="grid md:grid-cols-2  lg:grid-cols-4 gap-8">
    </div>

    <livewire:products.product-edit-modal />
</div>
