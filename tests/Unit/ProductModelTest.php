<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_producto()
    {
        $brand = Brand::factory()->create(['brand_name' => 'Nike']);
        $type  = ProductType::factory()->create(['product_type_name' => 'Zapatos']);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('test.jpg');

        $product = Product::createProduct([
            'brand_id' => $brand->brand_id,
            'product_type_id' => $type->product_type_id,
            'product_date' => '2024-01-01',
            'product_name' => 'Tennis Air',
            'product_stock' => 10,
            'product_price' => 999.99,
            'product_gender' => 'male',
            'product_image' => $file
        ]);

        $this->assertDatabaseHas('products', [
            'product_id' => $product->product_id,
            'product_name' => 'Tennis Air'
        ]);

        Storage::disk('public')->assertExists($product->product_image);
    }

    #[Test]
    public function puede_actualizar_un_producto()
    {
        $product = Product::factory()->create([
            'product_name' => 'Old Name'
        ]);

        Product::updateProduct($product->product_id, [
            'product_name' => 'New Name'
        ]);

        $this->assertEquals('New Name', $product->fresh()->product_name);
    }

    #[Test]
    public function puede_eliminar_un_producto()
    {
        Storage::fake('public');

        $product = Product::factory()->create([
            'product_image' => 'products/test.jpg'
        ]);

        Storage::disk('public')->put('products/test.jpg', 'fake');

        Product::deleteProduct($product->product_id);

        $this->assertDatabaseMissing('products', [
            'product_id' => $product->product_id
        ]);

        Storage::disk('public')->assertMissing('products/test.jpg');
    }

    #[Test]
    public function relacion_brand_funciona()
    {
        $product = Product::factory()->create();
        $this->assertInstanceOf(Brand::class, $product->brand);
    }

    #[Test]
    public function relacion_product_type_funciona()
    {
        $product = Product::factory()->create();
        $this->assertInstanceOf(ProductType::class, $product->productType);
    }

    #[Test]
    public function generate_product_code_incrementa_correctamente()
    {
        Product::factory()->create(['product_code' => 'PROD_001']);
        $secondCode = Product::generateProductCode();

        $this->assertEquals('PROD_002', $secondCode);
    }

 #[Test]
public function scope_available_funciona()
{
    Product::factory()->create(['product_availability_status' => 'available']);
    Product::factory()->create(['product_availability_status' => 'discontinued']);

    $available = Product::available()->get();

    $this->assertCount(1, $available);
}



    #[Test]
    public function accessor_formatted_price_funciona()
    {
        $product = Product::factory()->create(['product_price' => 250]);

        $this->assertEquals('$250.00', $product->formatted_price);
    }

    #[Test]
    public function accessor_gender_label_funciona()
    {
        $product = Product::factory()->create(['product_gender' => 'female']);

        $this->assertEquals('Femenino', $product->gender_label);
    }

    #[Test]
    public function crea_producto_con_imagen_default_si_no_envio_archivo()
    {
        $brand = Brand::factory()->create();
        $type  = ProductType::factory()->create();

        $product = Product::createProduct([
            'brand_id' => $brand->brand_id,
            'product_type_id' => $type->product_type_id,
            'product_date' => '2024-01-01',
            'product_name' => 'Sin Imagen',
            'product_stock' => 5,
            'product_price' => 100,
        ]);

        $this->assertEquals('products/default.png', $product->product_image);
    }
}
