<?php

namespace Tests\Feature\Brands;

use Tests\TestCase;
use App\Models\Brand;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Brands\BrandTable;
use PHPUnit\Framework\Attributes\Test;

class BrandTableTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function muestra_las_brands_en_la_tabla()
    {
        Brand::factory()->count(3)->create();

        $component = Livewire::test(BrandTable::class);

        $brands = $component->viewData('brands');

        $this->assertCount(3, $brands);
    }

    #[Test]
    public function ordena_las_brands_correctamente()
    {
        Brand::factory()->create(['brand_name' => 'Zeta']);
        Brand::factory()->create(['brand_name' => 'Alpha']);

        $component = Livewire::test(BrandTable::class);

        $brands = $component->viewData('brands');

        $this->assertEquals('Alpha', $brands->first()->brand_name);
    }

    #[Test]
    public function cambia_el_ordenamiento_correctamente()
    {
        $component = Livewire::test(BrandTable::class);

        $component->call('sort', 'brand_id')
            ->assertSet('sortBy.column', 'brand_id')
            ->assertSet('sortBy.direction', 'asc');

        $component->call('sort', 'brand_id')
            ->assertSet('sortBy.direction', 'desc');
    }

    #[Test]
    public function dispatch_evento_createBrand()
    {
        Livewire::test(BrandTable::class)
            ->call('createBrand')
            ->assertDispatched('createBrand');
    }

    #[Test]
    public function dispatch_evento_editBrand()
    {
        $brand = Brand::factory()->create();

        Livewire::test(BrandTable::class)
            ->call('editBrand', $brand->brand_id)
            ->assertDispatched('editBrand', brandId: $brand->brand_id);
    }

    #[Test]
    public function dispatch_evento_deleteBrand()
    {
        $brand = Brand::factory()->create();

        Livewire::test(BrandTable::class)
            ->call('deleteBrand', $brand->brand_id)
            ->assertDispatched('deleteBrand', brandId: $brand->brand_id);
    }

    #[Test]
    public function refresca_la_tabla_cuando_recibe_brandUpdated()
    {
        $component = Livewire::test(BrandTable::class);

        $component->dispatch('brandUpdated');

        $component->assertOk();
    }
}
