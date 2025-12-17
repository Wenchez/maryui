<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BrandModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_una_marca()
    {
        $brand = Brand::createBrand([
            'brand_name' => 'Apple',
            'brand_description' => 'Tecnología'
        ]);

        $this->assertDatabaseHas('brands', [
            'brand_name' => 'Apple'
        ]);
    }

    #[Test]
    public function puede_actualizar_una_marca()
    {
        $brand = Brand::factory()->create();

        $updated = Brand::updateBrand($brand->brand_id, [
            'brand_name' => 'Nueva Marca',
            'brand_description' => 'Actualizado'
        ]);

        $this->assertEquals('Nueva Marca', $updated->brand_name);
    }

    #[Test]
    public function puede_eliminar_una_marca()
    {
        $brand = Brand::factory()->create();

        $deleted = Brand::deleteBrand($brand->brand_id);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('brands', [
            'brand_id' => $brand->brand_id,
        ]);
    }

    #[Test]
    public function no_puede_eliminar_marca_con_productos_asociados()
    {
        $brand = Brand::factory()->create();

        // Crear producto asociado
        Product::factory()->create([
            'brand_id' => $brand->brand_id,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No se puede eliminar la marca porque tiene productos asociados.');

        Brand::deleteBrand($brand->brand_id);
    }

    #[Test]
    public function fillable_esta_correcto()
    {
        $this->assertEquals(
            ['brand_name', 'brand_description'],
            (new Brand)->getFillable()
        );
    }

    #[Test]
    public function relacion_products_funciona()
    {
        $brand = Brand::factory()->create();

        Product::factory()->count(3)->create([
            'brand_id' => $brand->brand_id,
        ]);

        $this->assertCount(3, $brand->products);
    }

    #[Test]
    public function obtiene_todas_las_marcas_ordenadas()
    {
        Brand::factory()->create(['brand_name' => 'Zara']);
        Brand::factory()->create(['brand_name' => 'Adidas']);

        $brands = Brand::getAllBrands();

        $this->assertEquals(['Adidas', 'Zara'], $brands->pluck('brand_name')->toArray());
    }
}
