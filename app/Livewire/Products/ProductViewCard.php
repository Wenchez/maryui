<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class ProductViewCard extends Component
{
    public Product $product;

    protected $listeners = ['productUpdated' => 'render'];

    public function render()
    {
        return view('livewire.products.product-view-card');
    }
}
