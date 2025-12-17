<?php

namespace Tests\Feature\Livewire\Products;

use Tests\TestCase;
use App\Models\Product;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Products\ProductViewCard;

class ProductViewCardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renderiza_correctamente(): void
    {
        $product = Product::factory()->create();

        Livewire::test(ProductViewCard::class, ['product' => $product])
            ->assertStatus(200)
            ->assertViewIs('livewire.products.product-view-card');
    }

    #[Test]
    public function recibe_instancia_de_producto(): void
    {
        $product = Product::factory()->create([
            'product_name' => 'Perfume Test'
        ]);

        Livewire::test(ProductViewCard::class, ['product' => $product])
            ->assertSet('product.product_name', 'Perfume Test');
    }

    #[Test]
    public function se_rerenderiza_cuando_evento_product_updated_es_emitido(): void
    {
        $product = Product::factory()->create();

        Livewire::test(ProductViewCard::class, ['product' => $product])
            ->dispatch('productUpdated')
            ->assertViewIs('livewire.products.product-view-card');
    }

    #[Test]
    public function tiene_registrado_el_listener_product_updated(): void
    {
        $reflection = new \ReflectionClass(ProductViewCard::class);

        $listeners = $reflection->getDefaultProperties()['listeners'];

        $this->assertArrayHasKey('productUpdated', $listeners);
        $this->assertSame('render', $listeners['productUpdated']);
    }
}
