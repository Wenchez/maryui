<?php

namespace Tests\Feature\ProductTypes;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductType;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductTypeDeleteModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_con_datos_correctos()
    {
        $type = ProductType::factory()->create([
            'product_type_name' => 'Ropa'
        ]);

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeDeleteModal::class)
            ->dispatch('deleteProductType', $type->product_type_id)
            ->assertSet('showModal', true)
            ->assertSet('product_typeId', $type->product_type_id)
            ->assertSet('product_typeName', 'Ropa');
    }

    #[Test]
    public function puede_eliminar_correctamente_un_product_type_sin_relaciones()
    {
        $type = ProductType::factory()->create();

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeDeleteModal::class)
            ->dispatch('deleteProductType', $type->product_type_id)
            ->call('delete')
            ->assertSet('showModal', false)
            ->assertSet('errorMessage', null);

        $this->assertDatabaseMissing('product_types', [
            'product_type_id' => $type->product_type_id,
        ]);
    }

    #[Test]
    public function muestra_error_si_tiene_productos_relacionados()
    {
        $type = ProductType::factory()->create();

        Product::factory()->create([
            'product_type_id' => $type->product_type_id
        ]);

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeDeleteModal::class)
            ->dispatch('deleteProductType', $type->product_type_id)
            ->call('delete')
            ->assertSet('showModal', true) // No debe cerrarse
            ->assertSet('errorMessage', 'No se puede eliminar la categoría porque tiene productos asociados.');

        // Confirmar que no lo eliminó
        $this->assertDatabaseHas('product_types', [
            'product_type_id' => $type->product_type_id,
        ]);
    }

    #[Test]
    public function al_fallar_la_eliminacion_no_dispara_el_evento()
    {
        $type = ProductType::factory()->create();

        Product::factory()->create([
            'product_type_id' => $type->product_type_id
        ]);

        Livewire::test(\App\Livewire\ProductTypes\ProductTypeDeleteModal::class)
            ->dispatch('deleteProductType', $type->product_type_id)
            ->call('delete')
            ->assertNotDispatched('productTypeUpdated');
    }
}
