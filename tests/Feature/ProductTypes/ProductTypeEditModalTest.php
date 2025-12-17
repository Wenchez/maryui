<?php

namespace Tests\Feature\ProductTypes;

use Tests\TestCase;
use App\Models\ProductType;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductTypeEditModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_con_datos_correctos()
    {
        $type = ProductType::factory()->create([
            'product_type_name' => 'Original',
            'product_type_description' => 'Descripción original',
        ]);

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeEditModal::class)
            ->dispatch('editProductType', $type->product_type_id)
            ->assertSet('showModal', true)
            ->assertSet('product_typeId', $type->product_type_id)
            ->assertSet('product_type_name', 'Original')
            ->assertSet('product_type_description', 'Descripción original');
    }

    #[Test]
    public function puede_actualizar_un_product_type()
    {
        $type = ProductType::factory()->create();

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeEditModal::class)
            ->dispatch('editProductType', $type->product_type_id)
            ->set('product_type_name', 'Nuevo Nombre')
            ->set('product_type_description', 'Nueva descripción')
            ->call('update')
            ->assertSet('showModal', false);

        $this->assertDatabaseHas('product_types', [
            'product_type_id' => $type->product_type_id,
            'product_type_name' => 'Nuevo Nombre',
            'product_type_description' => 'Nueva descripción',
        ]);
    }

    #[Test]
    public function valida_errores_al_actualizar()
    {
        $type = ProductType::factory()->create();

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeEditModal::class)
            ->dispatch('editProductType', $type->product_type_id)
            ->set('product_type_name', '')
            ->call('update')
            ->assertHasErrors(['product_type_name' => 'required']);
    }
}
