<?php

namespace Tests\Feature\Sales;

use Tests\TestCase;
use App\Livewire\Sales\TicketModal;
use App\Models\Sale;

class TicketModalTest extends TestCase
{
    public function test_it_can_load_ticket()
    {
        $sale = Sale::factory()->create();

        $component = new TicketModal();

        $component->loadTicket($sale->sale_id);

        $this->assertEquals($sale->sale_id, $component->sale->sale_id);
        $this->assertTrue($component->showModal);
    }

    public function test_it_can_download_pdf_without_sale()
    {
        $component = new TicketModal();

        // Método debe ejecutarse sin crash aunque no haya venta
        $component->downloadPdf();

        $this->assertTrue(true); // placeholder para success
    }

    public function test_it_can_close_modal()
    {
        $component = new TicketModal();
        $component->showModal = true;
        $component->sale = new Sale();

        $component->close();

        $this->assertFalse($component->showModal);
        $this->assertNull($component->sale);
    }
}
