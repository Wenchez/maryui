<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductTypeModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_product_type()
    {
        $type = ProductType::createProductType([
            'product_type_name' => 'Accesorios',
            'product_type_description' => 'Productos varios',
        ]);

        $this->assertDatabaseHas('product_types', [
            'product_type_id' => $type->product_type_id,
            'product_type_name' => 'Accesorios',
        ]);
    }

    #[Test]
    public function puede_actualizar_un_product_type()
    {
        $type = ProductType::factory()->create();

        $updated = ProductType::updateProductType($type->product_type_id, [
            'product_type_name' => 'Nuevo Nombre',
        ]);

        $this->assertEquals('Nuevo Nombre', $updated->product_type_name);

        $this->assertDatabaseHas('product_types', [
            'product_type_id' => $type->product_type_id,
            'product_type_name' => 'Nuevo Nombre',
        ]);
    }

    #[Test]
    public function puede_eliminar_un_product_type_sin_relaciones()
    {
        $type = ProductType::factory()->create();

        $result = ProductType::deleteProductType($type->product_type_id);

        $this->assertTrue($result);

        $this->assertDatabaseMissing('product_types', [
            'product_type_id' => $type->product_type_id,
        ]);
    }

    #[Test]
    public function no_puede_eliminar_si_tiene_productos_relacionados()
    {
        $type = ProductType::factory()->create();

        // Crear producto asociado
        Product::factory()->create([
            'product_type_id' => $type->product_type_id
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No se puede eliminar la categoría porque tiene productos asociados.');

        ProductType::deleteProductType($type->product_type_id);
    }

    #[Test]
    public function relacion_con_productos_funciona()
    {
        $type = ProductType::factory()->create();

        $products = Product::factory()->count(3)->create([
            'product_type_id' => $type->product_type_id,
        ]);

        $this->assertCount(3, $type->products);
        $this->assertTrue($type->products->contains($products->first()));
    }

    #[Test]
    public function fillable_esta_configurado_correctamente()
    {
        $type = new ProductType();

        $this->assertEquals(
            ['product_type_name', 'product_type_description'],
            $type->getFillable()
        );
    }

    #[Test]
    public function get_all_types_devuelve_lista_correcta()
    {
        $types = ProductType::factory()->count(3)->create();

        $result = ProductType::getAllTypes();

        $this->assertCount(3, $result);

        // Comprobamos las claves reales que vienen en el primer elemento
        $this->assertEquals(
            ['product_type_id', 'product_type_name'],
            array_values(array_keys($result->first()->getAttributes()))
        );
    }
}
