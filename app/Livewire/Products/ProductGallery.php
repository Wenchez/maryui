<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class ProductGallery extends Component
{
    public $products = [];

    protected $listeners = ['productUpdated' => 'refreshProducts'];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::with(['brand', 'productType'])
            ->where('product_availability_status', 'available')
            ->get();
    }

    public function refreshProducts()
    {
        $this->loadProducts();
    }

    public function deleteProduct($productId)
    {
        $this->dispatch('deleteProduct', productId: $productId)->to('products.product-delete-modal');
    }


    public function render()
    {
        return view('livewire.products.product-gallery');
    }
}
