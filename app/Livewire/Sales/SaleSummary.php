<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Mary\Traits\Toast; 

class SaleSummary extends Component
{
    use Toast;

    public float $subtotal = 0;
    public float $tax = 0;
    public float $total = 0;
    public array $saleDetails = [];

    protected $listeners = ['sale-details-updated' => 'updateSummary'];

    public function updateSummary($details)
    {
        $this->saleDetails = $details;

        // Los totales vienen del SalePanel, pero si quieres puedes recalcularlos
        $this->subtotal = collect($details)->sum(fn($i) => $i['quantity'] * $i['unit_price']);
        $this->tax = round($this->subtotal * 0.16, 2);
        $this->total = round($this->subtotal + $this->tax, 2);
    }

    public function cancelSale()
    {
        $this->dispatch('clear-sale');
        $this->success(
            'Venta cancelada correctamente',
            'Operación revertida',
            position: 'toast-bottom toast-end',
            timeout: 2500
        );
    }

    public function processSale()
    {
        if (empty($this->saleDetails)) {
            $this->error('No hay productos para procesar.', 'Error');
            return;
        }

        if (!auth()->check()) {
            $this->error('Debes iniciar sesión.', 'Acceso restringido');
            return;
        }


        try {
            $sale = DB::transaction(function () {
                $sale = Sale::create([
                    'sale_date' => now(),
                    'user_id' => auth()->id(),
                ]);

                foreach ($this->saleDetails as $item) {
                    $sale->details()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);

                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->product_stock -= $item['quantity'];
                        $product->save(); // Actualiza el stock si es necesario
                    }
                }

                $sale->refreshTotals(); // calcula subtotal, iva, total
                return $sale;
            });

            $this->success(
                'Venta procesada correctamente.',
                'Éxito',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
            $this->dispatch('clear-sale');
            $this->dispatch('show-ticket', saleId: $sale->sale_id);

            $this->dispatch('sale-processed'); 
        } catch (\Throwable $e) {
            $this->error(
                'Error al procesar la venta.',
                'Error inesperado',
                position: 'toast-bottom toast-end'
            );
        }
    }

    public function render()
    {
        return view('livewire.sales.sale-summary');
    }
}
