<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Brand::create([
            'brand_name' => 'Calvin Klein',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'Guess',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'Tommy Hilfiger',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'DKNY',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'Karl Lagerfeld',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'Reebok',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
        Brand::create([
            'brand_name' => 'Steve Madden',
            'brand_description' => 'Marca de moda reconocida a nivel mundial',
        ]);
    }
}
