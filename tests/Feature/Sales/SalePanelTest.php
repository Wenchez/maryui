<?php

namespace Tests\Unit\Sales;

use Tests\TestCase;
use App\Livewire\Sales\SalePanel;
use Livewire\Livewire;

class SalePanelTest extends TestCase
{
    
    public function it_adds_a_product_to_the_sale()
    {
        $component = new SalePanel();

        $productData = [
            'product_id' => 1,
            'product_name' => 'Producto de prueba',
            'product_price' => 100,
            'stock' => 10,
        ];

        $component->addProduct($productData);

        $this->assertArrayHasKey(1, $component->saleDetails);
        $this->assertEquals(1, $component->saleDetails[1]['quantity']);
        $this->assertEquals(100, $component->subtotal);
        $this->assertEquals(16, $component->tax);
        $this->assertEquals(116, $component->total);
    }

    
    public function it_updates_product_quantity()
    {
        $component = new SalePanel();

        $component->saleDetails = [
            1 => [
                'product_id' => 1,
                'product_name' => 'Producto de prueba',
                'unit_price' => 50,
                'quantity' => 1,
                'stock' => 5,
            ]
        ];

        $component->updateQuantity(1, 3);

        $this->assertEquals(3, $component->saleDetails[1]['quantity']);
        $this->assertEquals(150, $component->subtotal);
        $this->assertEquals(24, $component->tax);
        $this->assertEquals(174, $component->total);
    }

    
    public function it_removes_a_product()
    {
        $component = new SalePanel();

        $component->saleDetails = [
            1 => [
                'product_id' => 1,
                'product_name' => 'Producto de prueba',
                'unit_price' => 50,
                'quantity' => 1,
                'stock' => 5,
            ]
        ];

        $component->removeProduct(1);

        $this->assertEmpty($component->saleDetails);
        $this->assertEquals(0, $component->subtotal);
        $this->assertEquals(0, $component->tax);
        $this->assertEquals(0, $component->total);
    }

    
    public function it_clears_the_sale()
    {
        $component = new SalePanel();

        $component->saleDetails = [
            1 => ['product_id' => 1, 'product_name' => 'Producto', 'unit_price' => 100, 'quantity' => 1, 'stock' => 10],
            2 => ['product_id' => 2, 'product_name' => 'Producto 2', 'unit_price' => 50, 'quantity' => 2, 'stock' => 5],
        ];

        $component->subtotal = 200;
        $component->tax = 32;
        $component->total = 232;

        $component->clearSale();

        $this->assertEmpty($component->saleDetails);
        $this->assertEquals(0, $component->subtotal);
        $this->assertEquals(0, $component->tax);
        $this->assertEquals(0, $component->total);
    }
}
