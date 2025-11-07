<div>
    <x-card title="Categorías" shadow separator class="border-5 shadow rounded-xl">
        <x-slot:menu>
            <x-button icon="o-plus" wire:click.prevent="createProductType" tooltip="Agregar nueva categoría"
                class="btn-success btn-circle" />
        </x-slot:menu>

        <x-table :headers="$headers" :rows="$product_types" :sort-by="$sortBy" with-pagination per-page="perPage"
            :per-page-values="[5, 10, 20]">

            @scope('cell_actions', $product_type)
                <div class="flex gap-2">
                    <x-button
                        icon="o-pencil"
                        wire:click.prevent="editProductType({{ $product_type->product_type_id }})"
                        tooltip="Editar"
                        class="btn-warning btn-circle"
                    />

                    <x-button
                        icon="o-trash"
                        wire:click.prevent="deleteProductType({{ $product_type->product_type_id }})"
                        tooltip="Eliminar"
                        class="btn-error btn-circle"
                    />
                </div>
            @endscope
        </x-table>

    </x-card>
</div>
