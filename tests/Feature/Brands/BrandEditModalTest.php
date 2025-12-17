<?php

namespace Tests\Feature\Brands;

use Tests\TestCase;
use App\Models\Brand;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Brands\BrandEditModal;

class BrandEditModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_y_carga_los_datos_correctos()
    {
        $brand = Brand::factory()->create([
            'brand_name' => 'Puma',
            'brand_description' => 'Ropa deportiva'
        ]);

        $component = Livewire::test(BrandEditModal::class)
            ->dispatch('editBrand', $brand->brand_id);

        $component->assertSet('showModal', true);
        $component->assertSet('brandId', $brand->brand_id);
        $component->assertSet('brand_name', 'Puma');
        $component->assertSet('brand_description', 'Ropa deportiva');
    }

    #[Test]
    public function valida_los_campos_al_actualizar()
    {
        $brand = Brand::factory()->create();

        Livewire::test(BrandEditModal::class)
            ->dispatch('editBrand', $brand->brand_id)
            ->set('brand_name', '') // requerido
            ->call('update')
            ->assertHasErrors(['brand_name' => 'required']);
    }

    #[Test]
    public function puede_actualizar_correctamente_la_brand()
    {
        $brand = Brand::factory()->create([
            'brand_name' => 'Reebok',
            'brand_description' => 'Original desc'
        ]);

        Livewire::test(BrandEditModal::class)
            ->dispatch('editBrand', $brand->brand_id)
            ->set('brand_name', 'Reebok Updated')
            ->set('brand_description', 'Nueva descripción')
            ->call('update')
            ->assertSet('showModal', false)
            ->assertDispatched('brandUpdated');

        $this->assertDatabaseHas('brands', [
            'brand_id' => $brand->brand_id,
            'brand_name' => 'Reebok Updated',
            'brand_description' => 'Nueva descripción',
        ]);
    }

    #[Test]
    public function se_cierra_el_modal_luego_de_actualizar()
    {
        $brand = Brand::factory()->create();

        Livewire::test(BrandEditModal::class)
            ->dispatch('editBrand', $brand->brand_id)
            ->set('brand_name', 'Changed Name')
            ->call('update')
            ->assertSet('showModal', false);
    }
}
