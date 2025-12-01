<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;
use Mary\Traits\Toast;

class ProductTypeCreateModal extends Component
{
    use Toast;
    public $product_type_name;
    public $product_type_description;
    public $showModal = false;
    
    protected $listeners = ['createProductType' => 'open'];

    protected $rules = [
        'product_type_name' => 'required|string|max:40',
        'product_type_description' => 'nullable|string|max:100',
    ];

    public function open()
    {
        $this->product_type_name = '';
        $this->product_type_description = '';
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate([
            'product_type_name' => 'required|string|max:40',
            'product_type_description' => 'nullable|string|max:100',
        ]);

        ProductType::createProductType([
            'product_type_name' => $this->product_type_name,
            'product_type_description' => $this->product_type_description,
        ]);

         $this->success(
            'Categoria creada correctamente!.',
            position: 'toast-bottom toast-end',
            timeout: 2500
        );

        $this->showModal = false;
        $this->dispatch('productTypeUpdated');
    }

    public function render()
    {
        return view('livewire.product-types.product-type-create-modal');
    }
}
