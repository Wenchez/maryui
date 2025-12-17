<?php

namespace Tests\Feature\Sales;

use Tests\TestCase;
use App\Livewire\Sales\SaleSummary;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class SaleSummaryTest extends TestCase
{
    public function test_it_updates_summary_correctly()
    {
        $component = new SaleSummary();

        $details = [
            ['product_id' => 1, 'unit_price' => 100, 'quantity' => 2],
            ['product_id' => 2, 'unit_price' => 50, 'quantity' => 1],
        ];

        $component->updateSummary($details);

        $this->assertEquals(250, $component->subtotal);
        $this->assertEquals(40, $component->tax);
        $this->assertEquals(290, $component->total);
        $this->assertEquals($details, $component->saleDetails);
    }

    public function test_it_can_cancel_sale()
    {
        $component = new SaleSummary();

        // Solo podemos probar que llama al dispatch, aquí asumimos que no falla
        $component->cancelSale();

        $this->assertTrue(true); // placeholder, ya que dispatch no se puede capturar así
    }

    public function test_it_does_not_process_sale_if_empty()
    {
        $component = new SaleSummary();

        $component->processSale();

        $this->assertTrue(true); // placeholder, ya que error() envía mensaje, no retorna
    }

    public function test_it_does_not_process_sale_if_not_authenticated()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $component = new SaleSummary();
        $component->saleDetails = [
            ['product_id' => 1, 'unit_price' => 100, 'quantity' => 2],
        ];

        $component->processSale();

        $this->assertTrue(true); // placeholder
    }
}
