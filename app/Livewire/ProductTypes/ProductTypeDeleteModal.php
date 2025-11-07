<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;

class ProductTypeDeleteModal extends Component
{
    public $product_typeId;
    public $product_typeName;
    public $showModal = false;
    public $errorMessage = null;
    
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
        try {
            ProductType::deleteProductType($this->product_typeId);
            $this->showModal = false;
            $this->dispatch('productTypeUpdated');
            $this->errorMessage = null; // limpiar mensaje en caso de éxito
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage(); // guardar mensaje de error
        }
    }

    public function render()
    {
        return view('livewire.product-types.product-type-delete-modal');
    }
}
