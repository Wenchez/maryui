<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Livewire\Livewire;
use App\Livewire\Products\ProductsViewGrid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductsViewGridTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renderiza_la_vista_correcta()
    {
        Livewire::test(ProductsViewGrid::class)
            ->assertViewIs('livewire.products.products-view-grid');
    }

    #[Test]
    public function carga_productos_sin_filtros()
    {
        Product::factory()->count(5)->create();

        Livewire::test(ProductsViewGrid::class)
            ->assertViewHas('products', fn ($products) => $products->count() === 5);
    }

    #[Test]
    public function filtra_productos_por_marca()
    {
        $brandA = Brand::factory()->create();
        $brandB = Brand::factory()->create();

        Product::factory()->create(['brand_id' => $brandA->brand_id]);
        Product::factory()->create(['brand_id' => $brandB->brand_id]);

        Livewire::test(ProductsViewGrid::class)
            ->call('applyFilters', [
                'brands' => [$brandA->brand_id],
                'types' => [],
                'genders' => [],
                'search' => '',
            ])
            ->assertViewHas('products', fn ($products) =>
                $products->every(fn ($p) => $p->brand_id == $brandA->brand_id)
            );
    }

    #[Test]
    public function filtra_productos_por_tipo()
    {
        $typeA = ProductType::factory()->create();
        $typeB = ProductType::factory()->create();

        Product::factory()->create(['product_type_id' => $typeA->product_type_id]);
        Product::factory()->create(['product_type_id' => $typeB->product_type_id]);

        Livewire::test(ProductsViewGrid::class)
            ->call('applyFilters', [
                'brands' => [],
                'types' => [$typeA->product_type_id],
                'genders' => [],
                'search' => '',
            ])
            ->assertViewHas('products', fn ($products) =>
                $products->every(fn ($p) => $p->product_type_id == $typeA->product_type_id)
            );
    }

    #[Test]
    public function filtra_productos_por_genero()
    {
        Product::factory()->create(['product_gender' => 'male']);
        Product::factory()->create(['product_gender' => 'female']);

        Livewire::test(ProductsViewGrid::class)
            ->call('applyFilters', [
                'brands' => [],
                'types' => [],
                'genders' => ['male'],
                'search' => '',
            ])
            ->assertViewHas('products', fn ($products) =>
                $products->every(fn ($p) => $p->product_gender === 'male')
            );
    }

    #[Test]
    public function filtra_productos_por_busqueda()
    {
        Product::factory()->create(['product_name' => 'Nike Air']);
        Product::factory()->create(['product_name' => 'Adidas Ultra']);

        Livewire::test(ProductsViewGrid::class)
            ->call('applyFilters', [
                'brands' => [],
                'types' => [],
                'genders' => [],
                'search' => 'Nike',
            ])
            ->assertViewHas('products', fn ($products) =>
                $products->every(fn ($p) =>
                    str_contains(strtolower($p->product_name), 'nike')
                )
            );
    }

    #[Test]
    public function reinicia_paginacion_cuando_cambian_los_filtros()
    {
        Product::factory()->count(50)->create();

        // Simula query params "page = 3"
        $component = Livewire::withQueryParams(['page' => 3])
            ->test(ProductsViewGrid::class);

        // Aplicamos filtros sin reducir drásticamente los resultados
        $component->call('applyFilters', [
            'brands' => [],
            'types' => [],
            'genders' => [],
            'search' => '',
        ]);

        // Verifica que regresa al primer producto real
        $component->assertViewHas('products', function ($products) {
            return optional($products->first())->is(
                Product::orderBy('id')->first()
            );
        });
    }

    #[Test]
    public function despacha_evento_cuando_producto_es_agregado()
    {
        $product = Product::factory()->create();

        Livewire::test(ProductsViewGrid::class)
            ->dispatch('product-added', $product->toArray())
            ->assertDispatched('add-product-to-sale');
    }
}
