<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;
use Mary\Traits\Toast;

class ProductTypeEditModal extends Component
{
    use Toast;
    public $product_typeId;
    public $product_type_name;
    public $product_type_description;
    public $showModal = false;
    
    protected $listeners = ['editProductType' => 'open'];

    protected $rules = [
        'product_type_name' => 'required|string|max:40',
        'product_type_description' => 'nullable|string|max:100',
    ];

    public function open($product_typeId)
    {
        $product_type = ProductType::findOrFail($product_typeId);

        $this->product_typeId = $product_type->product_type_id;
        $this->product_type_name = $product_type->product_type_name;
        $this->product_type_description = $product_type->product_type_description;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'product_type_name' => 'required|string|max:40',
            'product_type_description' => 'nullable|string|max:100',
        ]);

        ProductType::updateProductType($this->product_typeId, [
            'product_type_name' => $this->product_type_name,
            'product_type_description' => $this->product_type_description,
        ]);

        $this->success(
                'Categoria actualizada correctamente!.',
                position: 'toast-bottom toast-end',
                timeout: 2500
        );

        $this->showModal = false;
        $this->dispatch('productTypeUpdated');
    }

    public function render()
    {
        return view('livewire.product-types.product-type-edit-modal');
    }
}
