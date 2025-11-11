<div class="w-full">
    <x-header title="Productos" separator>
        <x-slot:actions>
            <livewire:products.product-create-modal />
        </x-slot:actions>
    </x-header>

   <livewire:products.product-gallery />


    <livewire:products.product-edit-modal />
</div>
