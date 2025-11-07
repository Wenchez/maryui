<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProductType::create([
            'product_type_name' => 'Bolsa',
            'product_type_description' => 'Bolsa',
        ]);
        ProductType::create([
            'product_type_name' => 'Cartera',
            'product_type_description' => 'Cartera',
        ]);
        ProductType::create([
            'product_type_name' => 'Mochila',
            'product_type_description' => 'Mochila',
        ]);
        ProductType::create([
            'product_type_name' => 'Perfume',
            'product_type_description' => 'Perfume',
        ]);
        ProductType::create([
            'product_type_name' => 'Tenis',
            'product_type_description' => 'Prenda de calzado',
        ]);
    }
}
