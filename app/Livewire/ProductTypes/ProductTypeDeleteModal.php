<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;

class ProductTypeDeleteModal extends Component
{
    public $product_typeId;
    public $product_typeName;
    public $showModal = false;
    
    protected $listeners = ['deleteProductType' => 'open'];

    public function open($product_typeId)
    {
        $product_type = ProductType::findOrFail($product_typeId);

        $this->product_typeId = $product_type->product_type_id;
        $this->product_typeName = $product_type->product_type_name;
        $this->showModal = true;
    }

    public function delete()
    {
        if ($this->product_typeId) {
            ProductType::deleteProductType($this->product_typeId);
            $this->showModal = false;
            $this->dispatch('productTypeUpdated');
        }
    }

    public function render()
    {
        return view('livewire.product-types.product-type-delete-modal');
    }
}
