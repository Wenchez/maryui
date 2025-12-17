<?php

namespace Tests\Feature\Brands;

use Tests\TestCase;
use App\Models\Brand;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Brands\BrandCreateModal;

class BrandCreateModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_con_el_evento_createBrand()
    {
        $component = Livewire::test(BrandCreateModal::class);

        $component->dispatch('createBrand');

        $component->assertSet('showModal', true);
        $component->assertSet('brand_name', '');
        $component->assertSet('brand_description', '');
    }

    #[Test]
    public function valida_los_campos_al_crear()
    {
        Livewire::test(BrandCreateModal::class)
            ->set('brand_name', '') // requerido
            ->call('create')
            ->assertHasErrors(['brand_name' => 'required']);
    }

    #[Test]
    public function puede_crear_una_brand_correctamente()
    {
        Livewire::test(BrandCreateModal::class)
            ->set('brand_name', 'Nike')
            ->set('brand_description', 'Marca deportiva')
            ->call('create')
            ->assertSet('showModal', false)
            ->assertDispatched('brandUpdated');

        $this->assertDatabaseHas('brands', [
            'brand_name' => 'Nike',
            'brand_description' => 'Marca deportiva',
        ]);
    }

    #[Test]
    public function se_cierra_el_modal_luego_de_crear()
    {
        Livewire::test(BrandCreateModal::class)
            ->set('brand_name', 'Adidas')
            ->call('create')
            ->assertSet('showModal', false);
    }
}
