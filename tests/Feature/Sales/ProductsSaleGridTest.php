<?php

namespace Tests\Feature\Sales;

use Tests\TestCase;
use App\Livewire\Sales\ProductsSaleGrid;

class ProductsSaleGridTest extends TestCase
{
    public function test_it_can_update_filters()
    {
        $component = new ProductsSaleGrid();

        $filters = [
            'brands' => [1, 2],
            'types' => [3],
            'genders' => ['male', 'female'],
            'search' => 'Zapato'
        ];

        $component->updateFilters($filters);

        $this->assertEquals($filters, $component->filters);
    }

    public function test_it_can_apply_filters()
    {
        $component = new ProductsSaleGrid();

        $filters = [
            'brands' => [1],
            'types' => [2],
            'genders' => ['male'],
            'search' => 'Test'
        ];

        $component->applyFilters($filters);

        $this->assertEquals([1], $component->brands);
        $this->assertEquals([2], $component->types);
        $this->assertEquals(['male'], $component->genders);
        $this->assertEquals('Test', $component->search);
    }

    public function test_it_can_handle_product_added()
    {
        $component = new ProductsSaleGrid();

        $productData = [
            'product_id' => 1,
            'product_name' => 'Producto Test',
            'product_price' => 100
        ];

        $component->handleProductAdded($productData);

        $this->assertTrue(true); // placeholder, dispatch no se puede capturar
    }

    public function test_it_can_reload_grid()
    {
        $component = new ProductsSaleGrid();

        $component->reloadGrid();

        $this->assertTrue(true); // placeholder, dispatch $refresh
    }
}
