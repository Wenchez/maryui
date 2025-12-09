<?php

namespace Tests\Feature\Livewire\Sales;

use App\Livewire\Sales\SaleDetailList;
use App\Models\Product;
use Livewire\Livewire;
use Tests\TestCase;

class SaleDetailListTest extends TestCase
{
    /** @test */
    public function it_renders_component()
    {
        Livewire::test(SaleDetailList::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_sets_details_correctly()
    {
        $details = [
            10 => ['quantity' => 2],
        ];

        Livewire::test(SaleDetailList::class)
            ->call('setDetails', $details)
            ->assertSet('saleDetails', $details);
    }

    /** @test */
    public function it_changes_quantity_within_stock()
    {
        $product = Product::create([
            'product_name' => 'Test',
            'product_stock' => 5
        ]);

        Livewire::test(SaleDetailList::class, [
            'saleDetails' => [
                $product->id => ['quantity' => 1]
            ]
        ])
        ->call('changeQuantity', $product->id, '3')
        ->assertSet("saleDetails.$product->id.quantity", 3)
        ->assertDispatched('update-quantity', $product->id, 3);
    }

    /** @test */
    public function it_limits_quantity_when_exceeding_stock()
    {
        $product = Product::create([
            'product_name' => 'Test',
            'product_stock' => 4
        ]);

        Livewire::test(SaleDetailList::class, [
            'saleDetails' => [
                $product->id => ['quantity' => 1]
            ]
        ])
        ->call('changeQuantity', $product->id, '999')
        ->assertSet("saleDetails.$product->id.quantity", 4); // stock máximo
    }

    /** @test */
    public function it_dispatches_event_on_delete()
    {
        Livewire::test(SaleDetailList::class)
            ->call('deleteProduct', 15)
            ->assertDispatched('remove-product', 15);
    }
}
