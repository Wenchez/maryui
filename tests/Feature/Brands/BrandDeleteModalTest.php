<?php

namespace Tests\Feature\Brands;

use Tests\TestCase;
use App\Models\Brand;
use Livewire\Livewire;
use App\Livewire\Brands\BrandDeleteModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BrandDeleteModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_con_el_evento_deleteBrand()
    {
        $brand = Brand::factory()->create([
            'brand_name' => 'Samsung',
        ]);

        $component = Livewire::test(BrandDeleteModal::class);

        // ejecutar listener
        $component->dispatch('deleteBrand', $brand->brand_id);

        $component
            ->assertSet('showModal', true)
            ->assertSet('brandId', $brand->brand_id)
            ->assertSet('brandName', 'Samsung');
    }

    #[Test]
    public function puede_eliminar_correctamente_la_brand()
    {
        $brand = Brand::factory()->create([
            'brand_name' => 'Sony',
        ]);

        Livewire::test(BrandDeleteModal::class)
            ->set('brandId', $brand->brand_id)
            ->call('delete')
            ->assertSet('showModal', false)
            ->assertDispatched('brandUpdated')
            ->assertSet('errorMessage', null);

        $this->assertDatabaseMissing('brands', [
            'brand_id' => $brand->brand_id,
        ]);
    }

    #[Test]
public function muestra_mensaje_de_error_si_falla_la_eliminacion()
{
    $component = Livewire::test(BrandDeleteModal::class)
        ->set('brandId', 9999) // no existe
        ->call('delete');

    // obtener el valor desde el componente
    $errorMessage = $component->get('errorMessage');

    $this->assertNotNull($errorMessage);
    $this->assertIsString($errorMessage);
    $this->assertNotEmpty($errorMessage);
}
}
