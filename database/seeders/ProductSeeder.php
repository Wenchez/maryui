<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $brands = Brand::all();
        $types  = ProductType::all();

        for ($i = 0; $i < 20; $i++) {
            $brand = $brands->random();
            $type  = $types->random();

            Product::createProduct([
                'brand_id' => $brand->brand_id,
                'product_type_id' => $type->product_type_id,
                'product_name' => $faker->words(2, true),
                'product_stock' => $faker->numberBetween(5, 50),
                'product_price' => $faker->randomFloat(2, 50, 500),
                'product_gender' => $faker->randomElement(['male', 'female', 'unisex']),
                'product_image' => null, // Esto hará que use default.jpeg
                'product_date' => now()->toDateString(),
            ]);
        }
    }
}
