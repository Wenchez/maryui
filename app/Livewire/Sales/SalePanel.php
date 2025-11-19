<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Product;
use Mary\Traits\Toast;

class SalePanel extends Component
{
    use Toast;

    public array $saleDetails = [];
    public float $subtotal = 0;
    public float $tax = 0;
    public float $total = 0;

    protected $listeners = [
        'product-added' => 'addProduct',
        'update-quantity' => 'updateQuantity',
        'remove-product' => 'removeProduct',
        'clear-sale' => 'clearSale',
    ];

    public function addProduct($productData)
    {
        $productId = $productData['product_id'];

        if (!isset($this->saleDetails[$productId])) {
            $this->saleDetails[$productId] = [
                'product_id' => $productId,
                'product_name' => $productData['product_name'],
                'product_image' => $productData['product_image'] ?? null,
                'unit_price' => $productData['product_price'],
                'quantity' => 1,
                'stock' => $productData['stock'] ?? 9999,
            ];

            $this->success(
                'Producto agregado.',
                'Lista actualizada',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );

            $this->recalculateTotals();
            $this->dispatch('sale-details-updated', $this->saleDetails);
        }
        else {
            $this->warning(
                'El producto ya está en la lista de venta.',
                'No es necesario agregarlo de nuevo',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
        }
    }


    public function updateQuantity($productId, $quantity)
    {
        if (!isset($this->saleDetails[$productId])) return;

        $max = $this->saleDetails[$productId]['stock'];
        $this->saleDetails[$productId]['quantity'] = max(1, min((int)$quantity, $max));

        if ($quantity <= 0) {
            unset($this->saleDetails[$productId]);
            $this->recalculateTotals();
            return;
        }

        $this->recalculateTotals();
        $this->dispatch('sale-details-updated', $this->saleDetails);
    }

    public function clearSale()
    {
        $this->reset(['saleDetails', 'subtotal', 'tax', 'total']);
        $this->dispatch('sale-details-updated', $this->saleDetails);
    }

    public function removeProduct($productId)
    {
        unset($this->saleDetails[$productId]);
        $this->recalculateTotals();
        $this->success(
                'Producto removido.',
                'Lista actualizada',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
        $this->dispatch('sale-details-updated', $this->saleDetails);
    }

    public function recalculateTotals()
    {
        $this->subtotal = collect($this->saleDetails)
            ->sum(fn($i) => $i['quantity'] * $i['unit_price']);

        $this->tax = round($this->subtotal * 0.16, 2);
        $this->total = round($this->subtotal + $this->tax, 2);
    }

    public function render()
    {
        return view('livewire.sales.sale-panel');
    }
}
