<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;
use Mary\Traits\Toast;

class ProductTypeDeleteModal extends Component
{
    use Toast;
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
        try {
            ProductType::deleteProductType($this->product_typeId);
            $this->success(
                'Categoria eliminada correctamente!.',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
            $this->showModal = false;
            $this->dispatch('productTypeUpdated');
            $this->errorMessage = null; // limpiar mensaje en caso de éxito
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage(); // guardar mensaje de error
            $this->error(
                'Error al eliminar la categoria:',
                $e->getMessage(),
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
        }

        
    }

    public function render()
    {
        return view('livewire.product-types.product-type-delete-modal');
    }
}
