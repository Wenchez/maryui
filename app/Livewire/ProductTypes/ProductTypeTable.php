<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductType;

class ProductTypeTable extends Component
{
    use WithPagination;

    public int $perPage = 5;

    public array $sortBy = ['column' => 'product_type_name', 'direction' => 'asc'];

    protected $listeners = ['productTypeUpdated' => '$refresh'];

    public function sort($column)
    {
        if ($this->sortBy['column'] === $column) {
            $this->sortBy['direction'] = $this->sortBy['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy['column'] = $column;
            $this->sortBy['direction'] = 'asc';
        }
    }

    public function createProductType()
    {
        $this->dispatch('createProductType')->to('product-types.product-type-create-modal');
    }

    public function editProductType($product_typeId)
    {
        $this->dispatch('editProductType', product_typeId: $product_typeId)->to('product-types.product-type-edit-modal');
    }

    public function deleteProductType($product_typeId)
    {
        $this->dispatch('deleteProductType', product_typeId: $product_typeId)->to('product-types.product-type-delete-modal');
    }

    public function render()
    {
        $product_types = ProductType::query()
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate($this->perPage);

        $headers = [
            ['key' => 'product_type_id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'product_type_name', 'label' => 'Nombre'],
            ['key' => 'product_type_description', 'label' => 'Descripción'],
            ['key' => 'actions', 'label' => 'Acciones', 'sortable' => false],
        ];

        return view('livewire.product-types.product-type-table', [
            'product_types' => $product_types,
            'headers' => $headers
        ]);
    }
}
