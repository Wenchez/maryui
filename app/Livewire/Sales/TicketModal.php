<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketModal extends Component
{
    public $showModal = false;
    public $sale;

    protected $listeners = ['show-ticket' => 'loadTicket'];

    public function loadTicket($saleId)
    {
        $this->sale = Sale::with('details.product', 'user')->find($saleId);
        $this->showModal = true;
    }

    public function downloadPdf()
    {
        if (!$this->sale) {
            $this->dispatch('notify', 'No hay venta cargada.');
            return;
        }

        // Recarga relaciones si es necesario
        $sale = $this->sale->load('details.product', 'user');

        $pdf = Pdf::loadView('pdf.ticket', compact('sale'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'ticket-' . $sale->sale_reference . '.pdf'
        );
    }

    public function close()
    {
        $this->reset(['showModal', 'sale']);
    }

    public function render()
    {
        return view('livewire.sales.ticket-modal');
    }
}
