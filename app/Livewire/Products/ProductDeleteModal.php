<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ProductDeleteModal extends Component
{   
    public $productId;
    public $productName;
    public $showModal = false;
    public $errorMessage = null;

    protected $listeners = ['deleteProduct' => 'open'];

     public function open($productId)
    {
        $product = Product::findOrFail($productId);

        $this->productId = $product->product_id;
        $this->productName = $product->product_name;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Product::deleteProduct($this->productId);
            $this->showModal = false;
            $this->dispatch('productUpdated');
            $this->errorMessage = null; // limpiar mensaje en caso de éxito
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage(); // guardar mensaje de error
        }
    }

    public function render()
    {
        return view('livewire.products.product-delete-modal');
    }
}
