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
        // Asegurarse de tener al menos un brand y un product type
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();
        $type  = ProductType::inRandomOrder()->first() ?? ProductType::factory()->create();

        $productName = $this->faker->words(2, true);
        $productCode = 'PROD_' . str_pad(Product::count() + 1, 3, '0', STR_PAD_LEFT);

        // Generar una imagen de prueba en storage/app/public/products
        $imagePath = $this->faker->image(storage_path('app/public/products'), 400, 400, null, false);

        return [
            'brand_id' => $brand->brand_id,
            'product_type_id' => $type->product_type_id,
            'product_date' => $this->faker->date(),
            'product_code' => $productCode,
            'product_name' => $productName,
            'product_stock' => $this->faker->numberBetween(5, 50),
            'product_price' => $this->faker->randomFloat(2, 50, 500),
            'product_gender' => $this->faker->randomElement(['male', 'female', 'unisex']),
            'product_image' => 'products/' . $imagePath,
            'product_availability_status' => 'available',
            'product_stock_status' => 'inStock',
        ];
    }
}
