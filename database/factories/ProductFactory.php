<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();
        $type  = ProductType::inRandomOrder()->first() ?? ProductType::factory()->create();

        return [
            'brand_id' => $brand->brand_id,
            'product_type_id' => $type->product_type_id,
            'product_date' => $this->faker->date(),
            'product_name' => $this->faker->words(2, true),
            'product_stock' => $this->faker->numberBetween(5, 50),
            'product_price' => $this->faker->randomFloat(2, 50, 500),
            'product_gender' => $this->faker->randomElement(['male', 'female', 'unisex']),
            'product_image' => 'products/default.png',
            'product_availability_status' => 'available',
            'product_stock_status' => 'inStock',
        ];
    }
}
