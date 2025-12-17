<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class SaleModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_una_venta_con_detalles_y_calcular_totales()
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(3)->create();

        $sale = Sale::factory()->create(['user_id' => $user->user_id]);

        foreach ($products as $product) {
            $sale->details()->create([
                'product_id' => $product->product_id,
                'quantity' => 2,
                'unit_price' => $product->product_price,
            ]);
        }

        $sale->calculateTotals();
        $sale->save();
        $sale->load('details');

        $this->assertNotEmpty($sale->details);
        $this->assertGreaterThan(0, $sale->sale_subtotal);
        $this->assertEquals(round($sale->sale_subtotal * 0.16, 2), $sale->sale_tax);
        $this->assertEquals(round($sale->sale_subtotal + $sale->sale_tax, 2), $sale->sale_total);
        $this->assertStringStartsWith('XB-', $sale->sale_reference);
    }

    #[Test]
    public function puede_crear_una_venta_usando_create_with_details()
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(2)->create();

        $details = $products->map(fn($p) => [
            'product_id' => $p->product_id,
            'quantity' => 1,
            'unit_price' => $p->product_price,
        ])->toArray();

        $sale = Sale::createWithDetails([
            'user_id' => $user->user_id,
            'sale_date' => now(),
        ], $details);

        $sale->load('details');

        $this->assertCount(2, $sale->details);
        $this->assertGreaterThan(0, $sale->sale_total);
        $this->assertStringStartsWith('XB-', $sale->sale_reference);
    }

    #[Test]
    public function puede_agregar_y_eliminar_productos_de_una_venta()
    {
        $products = Product::factory()->count(2)->create();
        $sale = Sale::factory()->create(['sale_date' => now()]);

        $sale->addProduct($products[0]->product_id, 2);
        $sale->addProduct($products[1]->product_id, 1);
        $sale->refreshTotals();

        $this->assertCount(2, $sale->details);
        $this->assertEquals(2, $sale->details()->where('product_id', $products[0]->product_id)->first()->quantity);

        // Remover un producto
        $sale->removeProduct($products[0]->product_id);
        $sale->refreshTotals();

        $this->assertCount(1, $sale->details);
        $this->assertNull($sale->details()->where('product_id', $products[0]->product_id)->first());
    }

    #[Test]
    public function puede_actualizar_cantidad_si_producto_ya_existe()
    {
        $product = Product::factory()->create();
        $sale = Sale::factory()->create(['sale_date' => now()]);

        $sale->addProduct($product->product_id, 1);
        $sale->addProduct($product->product_id, 3); // debe sumar
        $sale->refreshTotals();

        $this->assertEquals(4, $sale->details()->where('product_id', $product->product_id)->first()->quantity);
    }

    #[Test]
    public function puede_calcular_totales_con_venta_sin_detalles()
    {
        $sale = Sale::factory()->create(['sale_date' => now()]);
        $sale->calculateTotals();
        $sale->save();

        $this->assertEquals(0, $sale->sale_subtotal);
        $this->assertEquals(0, $sale->sale_tax);
        $this->assertEquals(0, $sale->sale_total);
    }

    #[Test]
    public function sale_detail_calcula_line_total_y_formatos_correctamente()
    {
        $product = Product::factory()->create(['product_price' => 123.45]);
        $sale = Sale::factory()->create(['sale_date' => now()]);

        $detail = $sale->details()->create([
            'product_id' => $product->product_id,
            'quantity' => 2,
            'unit_price' => $product->product_price,
        ]);

        $this->assertEquals(246.90, $detail->line_total);
        $this->assertEquals('$246.90', $detail->formatted_line_total);
        $this->assertEquals('$123.45', $detail->formatted_unit_price);
    }

    #[Test]
    public function create_with_details_hace_rollback_en_caso_de_error()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $user = User::factory()->create();
        $products = Product::factory()->count(1)->create();

        // Simular error: detalle con product_id inexistente
        Sale::createWithDetails([
            'user_id' => $user->user_id,
            'sale_date' => now(),
        ], [
            ['product_id' => 99999, 'quantity' => 1, 'unit_price' => 100],
        ]);
    }
}
