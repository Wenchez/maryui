<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;

class ProductSaleCard extends Component
{
    public Product $product;

    public function addProductToSale()
    {
        $this->dispatch('product-added', [
            'product_id' => $this->product->product_id,
            'product_name' => $this->product->product_name,
            'product_price' => $this->product->product_price,
            'product_image' => $this->product->product_image_url,
        ]);
    }

    public function render()
    {
        return view('livewire.sales.product-sale-card');
    }
}
