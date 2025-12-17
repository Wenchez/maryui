<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'brand_name' => $this->faker->unique()->company(),   // nombre obligatorio
            'brand_description' => $this->faker->sentence(),     // descripción opcional
        ];
    }
}

