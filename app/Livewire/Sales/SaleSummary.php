<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleSummary extends Component
{
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
        $this->dispatch('notify', 'Venta cancelada.');
    }

    public function processSale()
    {
        if (empty($this->saleDetails)) {
            $this->dispatch('notify', 'No hay productos para procesar.');
            return;
        }

        if (!auth()->check()) {
            $this->dispatch('notify', 'Debes iniciar sesión para procesar la venta.');
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
                        $product->decrement('product_stock', $item['quantity']);
                    }
                }

                $sale->refreshTotals(); // calcula subtotal, iva, total
                return $sale;
            });

            $this->dispatch('notify', 'Venta procesada correctamente.');
            $this->dispatch('clear-sale');
            $this->dispatch('show-ticket', saleId: $sale->sale_id);
        } catch (\Throwable $e) {
            $this->dispatch('notify', 'Error al procesar la venta.');
        }
    }

    public function ticketPdf($saleId)
    {
        $sale = Sale::with('details.product', 'user')->findOrFail($saleId);
        $pdf = Pdf::loadView('pdf.ticket', compact('sale'));
        return $pdf->download('ticket-' . $sale->sale_reference . '.pdf');
    }

    public function render()
    {
        return view('livewire.sales.sale-summary');
    }
}
