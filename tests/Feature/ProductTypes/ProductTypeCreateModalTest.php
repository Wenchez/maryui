<?php

namespace Tests\Feature\ProductTypes;

use Tests\TestCase;
use App\Models\ProductType;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductTypeCreateModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_correctamente()
    {
        Livewire::test(\App\Livewire\ProductTypes\ProductTypeCreateModal::class)
            ->dispatch('createProductType')
            ->assertSet('showModal', true)
            ->assertSet('product_type_name', '')
            ->assertSet('product_type_description', '');
    }

    #[Test]
    public function puede_crear_un_product_type()
    {
        Livewire::test(\App\Livewire\ProductTypes\ProductTypeCreateModal::class)
            ->set('product_type_name', 'Carteras')
            ->set('product_type_description', 'Carteras de moda')
            ->call('create')
            ->assertSet('showModal', false);

        $this->assertDatabaseHas('product_types', [
            'product_type_name' => 'Carteras',
            'product_type_description' => 'Carteras de moda',
        ]);
    }

    #[Test]
    public function valida_errores_al_crear()
    {
        Livewire::test(\App\Livewire\ProductTypes\ProductTypeCreateModal::class)
            ->set('product_type_name', '')
            ->call('create')
            ->assertHasErrors(['product_type_name' => 'required']);
    }
}
