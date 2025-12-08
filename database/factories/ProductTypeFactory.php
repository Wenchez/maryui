<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductType;

class ProductTypeFactory extends Factory
{
    protected $model = ProductType::class;

    public function definition()
    {
        return [
            'product_type_name' => $this->faker->unique()->word(),
            'product_type_description' => $this->faker->sentence(), 
        ];
    }
}
