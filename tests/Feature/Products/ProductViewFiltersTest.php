<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Brand;
use App\Models\ProductType;
use App\Livewire\Products\ProductViewFilters;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductViewFiltersTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renderiza_vista_correcta()
    {
        Livewire::test(ProductViewFilters::class)
            ->assertViewIs('livewire.products.product-view-filters');
    }

    #[Test]
    public function carga_marcas_y_tipos_disponibles_en_mount()
    {
        $brand = Brand::factory()->create(['brand_name' => 'Adidas']);
        $type  = ProductType::factory()->create(['product_type_name' => 'Casual']);

        Livewire::test(ProductViewFilters::class)
            ->assertSet('availableBrands', [$brand->brand_id => 'Adidas'])
            ->assertSet('availableTypes', [$type->product_type_id => 'Casual']);
    }

    #[Test]
    public function inicializa_filtros_seleccionados_desde_mount()
    {
        $brand = Brand::factory()->create();
        $type = ProductType::factory()->create();

        $filters = [
            'brands' => [$brand->brand_id],
            'types' => [$type->product_type_id],
            'genders' => ['male'],
            'search' => 'nike',
        ];

        Livewire::test(ProductViewFilters::class, ['filters' => $filters])
            ->assertSet('selectedBrands', [(string) $brand->brand_id])
            ->assertSet('selectedTypes', [(string) $type->product_type_id])
            ->assertSet('selectedGenders', ['male'])
            ->assertSet('search', 'nike');
    }

    #[Test]
    public function limpia_todos_los_filtros_con_clearFilters()
    {
        $brand = Brand::factory()->create();
        $type = ProductType::factory()->create();

        Livewire::test(ProductViewFilters::class)
            ->set('selectedBrands', [(string)$brand->brand_id])
            ->set('selectedTypes', [(string)$type->product_type_id])
            ->set('selectedGenders', ['female'])
            ->set('search', 'adidas')
            ->call('clearFilters')
            ->assertSet('selectedBrands', [])
            ->assertSet('selectedTypes', [])
            ->assertSet('selectedGenders', [])
            ->assertSet('search', '');
    }

    #[Test]
    public function limpia_solo_marcas()
    {
        Livewire::test(ProductViewFilters::class)
            ->set('selectedBrands', ['1'])
            ->call('clearBrands')
            ->assertSet('selectedBrands', []);
    }

    #[Test]
    public function limpia_solo_tipos()
    {
        Livewire::test(ProductViewFilters::class)
            ->set('selectedTypes', ['1'])
            ->call('clearTypes')
            ->assertSet('selectedTypes', []);
    }

    #[Test]
    public function limpia_solo_generos()
    {
        Livewire::test(ProductViewFilters::class)
            ->set('selectedGenders', ['male'])
            ->call('clearGenders')
            ->assertSet('selectedGenders', []);
    }

    #[Test]
    public function limpia_busqueda()
    {
        Livewire::test(ProductViewFilters::class)
            ->set('search', 'nike')
            ->call('clearSearch')
            ->assertSet('search', '');
    }
}
