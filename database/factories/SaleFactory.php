<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'sale_date' => now(),
            'user_id' => User::factory(), // para crear un usuario asociado automáticamente si quieres
            'sale_subtotal' => 0,
            'sale_tax' => 0,
            'sale_total' => 0,
        ];
    }
}
