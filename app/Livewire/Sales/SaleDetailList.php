<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;
use Mary\Traits\Toast;

class SaleDetailList extends Component
{
    use Toast;

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
            $this->error(
                'No hay suficiente stock.',
                'Stock insuficiente',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
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
