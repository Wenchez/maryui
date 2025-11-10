<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;

class SaleDetailList extends Component
{
    public array $saleDetails = [];

    protected $listeners = ['sale-details-updated' => 'setDetails'];

    public function setDetails($details)
    {
        $this->saleDetails = $details;
    }

    public function changeQuantity($productId, $value)
    {
        $quantity = (int) preg_replace('/[^0-9]/', '', $value);

        if ($quantity < 1) {
            $quantity = 1;
        }

        $stock = Product::find($productId)?->product_stock ?? 0;
        if ($quantity > $stock) {
            $quantity = $stock;
            $this->dispatch('notify', 'No hay suficiente stock disponible.');
        }

        $this->saleDetails[$productId]['quantity'] = $quantity;
        $this->dispatch('update-quantity', (int)$productId, $quantity);
    }


    public function deleteProduct($productId)
    {
        $this->dispatch('remove-product', $productId);
    }

    public function render()
    {
        return view('livewire.sales.sale-detail-list');
    }
}
