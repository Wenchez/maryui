<?php

namespace Tests\Feature\ProductTypes;

use Tests\TestCase;
use App\Models\ProductType;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use App\Livewire\ProductTypes\ProductTypeTable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTypeTableTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renderiza_correctamente(): void
    {
        Livewire::test(ProductTypeTable::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.product-types.product-type-table');
    }

    #[Test]
    public function ordena_columnas_correctamente(): void
    {
        $component = Livewire::test(ProductTypeTable::class);

        // Estado inicial
        $component->assertSet('sortBy.column', 'product_type_name');
        $component->assertSet('sortBy.direction', 'asc');

        // Cambio de columna
        $component->call('sort', 'product_type_description')
            ->assertSet('sortBy.column', 'product_type_description')
            ->assertSet('sortBy.direction', 'asc');

        // Reversión
        $component->call('sort', 'product_type_description')
            ->assertSet('sortBy.direction', 'desc');
    }

    #[Test]
    public function dispara_evento_de_creacion(): void
    {
        Livewire::test(ProductTypeTable::class)
            ->call('createProductType')
            ->assertDispatched('createProductType');
    }

    #[Test]
    public function dispara_evento_de_edicion(): void
    {
        $type = ProductType::factory()->create();

        Livewire::test(ProductTypeTable::class)
            ->call('editProductType', $type->product_type_id)
            ->assertDispatched('editProductType');
    }

    #[Test]
    public function dispara_evento_de_eliminacion(): void
    {
        $type = ProductType::factory()->create();

        Livewire::test(ProductTypeTable::class)
            ->call('deleteProductType', $type->product_type_id)
            ->assertDispatched('deleteProductType');
    }

    #[Test]
    public function pagina_los_resultados_correctamente(): void
    {
        ProductType::factory()->count(20)->create();

        Livewire::test(ProductTypeTable::class)
            ->assertSet('perPage', 5)
            ->assertViewHas('product_types', function ($paginator) {
                return $paginator->perPage() === 5
                    && $paginator->total() === 20;
            });
    }
}
