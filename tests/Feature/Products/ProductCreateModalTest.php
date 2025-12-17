<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductType;
use App\Livewire\Products\ProductCreateModal;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductCreateModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_modal_se_abre_correctamente()
    {
        $component = Livewire::test(ProductCreateModal::class);

        $component->call('open');

        $component->assertSet('showModal', true);
        $component->assertSet('product_image', null);
        $component->assertSet('product_name', null);
    }

    #[Test]
    public function valida_los_campos_requeridos()
    {
        Livewire::test(ProductCreateModal::class)
            ->set('brand_id', '')
            ->set('product_type_id', '')
            ->set('product_name', '')
            ->set('product_stock', '')
            ->set('product_price', '')
            ->call('store')
            ->assertHasErrors([
                'brand_id' => 'required',
                'product_type_id' => 'required',
                'product_name' => 'required',
                'product_stock' => 'required',
                'product_price' => 'required',
            ]);
    }

    #[Test]
    public function puede_crear_un_producto_correctamente()
    {
        $brand = Brand::factory()->create();
        $type = ProductType::factory()->create();

        Livewire::test(ProductCreateModal::class)
            ->set('brand_id', $brand->brand_id)
            ->set('product_type_id', $type->product_type_id)
            ->set('product_name', 'Tenis Nike')
            ->set('product_stock', 10)
            ->set('product_price', 1500)
            ->set('product_gender', 'unisex')
            ->call('store')
            ->assertSet('showModal', false)
            ->assertDispatched('product-updated');

        $this->assertDatabaseHas('products', [
            'product_name' => 'Tenis Nike',
            'brand_id' => $brand->brand_id,
        ]);
    }

    #[Test]
    public function puede_subir_una_imagen_valida()
    {
        $brand = Brand::factory()->create();
        $type = ProductType::factory()->create();

        $image = UploadedFile::fake()->image('tenis.jpg');

        Livewire::test(ProductCreateModal::class)
            ->set('brand_id', $brand->brand_id)
            ->set('product_type_id', $type->product_type_id)
            ->set('product_name', 'Producto con imagen')
            ->set('product_stock', 5)
            ->set('product_price', 999)
            ->set('product_gender', 'male')
            ->set('product_image', $image)
            ->call('store')
            ->assertHasNoErrors();
    }
}
