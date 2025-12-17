<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition()
    {
        // Obtener un sale y un product existentes o crear nuevos
        $sale = Sale::inRandomOrder()->first() ?? Sale::factory()->create();
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $product->product_price;

        return [
            'sale_id' => $sale->sale_id,
            'product_id' => $product->product_id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            // line_total es virtual en la DB, no se necesita aquí
        ];
    }
}
