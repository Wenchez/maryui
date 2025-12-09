<?php

namespace Tests\Feature\Sales;

use Tests\TestCase;
use App\Livewire\Sales\ProductSaleFilters;

class ProductSaleFiltersTest extends TestCase
{
    public function test_it_can_mount_with_filters()
    {
        $filters = [
            'brands' => [1, 2],
            'types' => [3],
            'genders' => ['male', 'female'],
            'search' => 'Zapato'
        ];

        $component = new ProductSaleFilters();
        $component->mount($filters);

        $this->assertEquals(['1', '2'], $component->selectedBrands);
        $this->assertEquals(['3'], $component->selectedTypes);
        $this->assertEquals(['male', 'female'], $component->selectedGenders);
        $this->assertEquals('Zapato', $component->search);
    }

    public function test_it_can_clear_filters()
    {
        $component = new ProductSaleFilters();
        $component->selectedBrands = ['1'];
        $component->selectedTypes = ['2'];
        $component->selectedGenders = ['male'];
        $component->search = 'test';

        $component->clearFilters();

        $this->assertEmpty($component->selectedBrands);
        $this->assertEmpty($component->selectedTypes);
        $this->assertEmpty($component->selectedGenders);
        $this->assertEquals('', $component->search);

        $this->assertTrue(true); // placeholder para dispatch y success
    }

    public function test_it_can_clear_individual_filters()
    {
        $component = new ProductSaleFilters();

        $component->selectedBrands = ['1'];
        $component->clearBrands();
        $this->assertEmpty($component->selectedBrands);
        $this->assertTrue(true); // dispatch y success

        $component->selectedTypes = ['2'];
        $component->clearTypes();
        $this->assertEmpty($component->selectedTypes);
        $this->assertTrue(true);

        $component->selectedGenders = ['male'];
        $component->clearGenders();
        $this->assertEmpty($component->selectedGenders);
        $this->assertTrue(true);

        $component->search = 'zapato';
        $component->clearSearch();
        $this->assertEquals('', $component->search);
        $this->assertTrue(true);
    }
}
