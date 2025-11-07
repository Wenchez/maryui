<div>
    <x-card title="Marcas" shadow separator class="border-5 shadow rounded-xl">
        <x-slot:menu>
            <x-button icon="o-plus" wire:click.prevent="createBrand" tooltip="Agregar nueva marca"
                class="btn-success btn-circle" />
        </x-slot:menu>

        <x-table :headers="$headers" :rows="$brands" :sort-by="$sortBy" with-pagination per-page="perPage"
            :per-page-values="[5, 10, 20]">

            @scope('cell_actions', $brand)
                <div class="flex gap-2">
                    <x-button
                        icon="o-pencil"
                        wire:click.prevent="editBrand({{ $brand->brand_id }})"
                        tooltip="Editar"
                        class="btn-warning btn-circle"
                    />

                    <x-button
                        icon="o-trash"
                        wire:click.prevent="deleteBrand({{ $brand->brand_id }})"
                        tooltip="Eliminar"
                        class="btn-error btn-circle"
                    />
                </div>
            @endscope
        </x-table>

    </x-card>
</div>
