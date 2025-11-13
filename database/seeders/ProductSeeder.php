<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $brands = Brand::pluck('brand_id', 'brand_name')->toArray();
        $productTypes = ProductType::pluck('product_type_id', 'product_type_name')->toArray();

        $productsToSeed = [
            ['Bolsa Cafe',     1680, 'Guess',          'Bolsa',         'female', 11],
            ['Bolsa grande Cafe',    1780, 'Guess',          'Bolsa',         'female', 9],
            ['Crossbody Guess',      1450, 'Guess',          'Crossbody',     'female', 13],
            ['Crossbody Tommy',      1180, 'Tommy Hilfiger', 'Crossbody',     'female', 16],
            ['Crossbody Karl',       2600, 'Karl Lagerfeld', 'Crossbody',     'female', 15],
            ['Crossbody Steve Madden',      1380, 'Steve Madden',   'Crossbody',     'female', 14],
            ['Crossbody Leopardo',   1180, 'Steve Madden',   'Crossbody',     'female', 10],
            ['Mochila Negra',        1780, 'Guess',          'Mochila',       'female', 17],
            ['Set bolso, monedero y llavero', 1680, 'Steve Madden',   'Set',           'female', 8],
            ['Sudadera roja',        950,  'DKNY',           'Sudadera',      'female', 25],
            ['Sudadera blanca',      950,  'Calvin Klein',   'Sudadera',      'female', 20],
            ['Tenis Rosas',           990,  'Guess',          'Tenis',         'female', 18],
            ['Tenis Blancos',         990,  'Guess',          'Tenis',         'female', 22],
            ['Tenis Rojos',          990,  'Guess',          'Tenis',         'female', 15],
            ['Tenis Negros',         990,  'Guess',          'Tenis',         'female', 10],
        ];

        foreach ($productsToSeed as $index => $item) {
            
            $productName = $item[0];
            $price = $item[1];
            $brandName = $item[2];
            $typeName = $item[3];
            $gender = $item[4];
            $stock = $item[5];
            $productCode = 'PROD_' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            $filename = Product::generateImageFilename(
                $typeName,
                $brandName,
                $productCode,
                $productName,
                'jpg' 
            );

            Product::create([
                'brand_id' => $brands[$brandName],
                'product_type_id' => $productTypes[$typeName],
                'product_date' => now()->subDays($index)->toDateString(),
                'product_code' => $productCode,
                'product_name' => $productName,
                'product_stock' => $stock,
                'product_price' => $price,
                'product_gender' => $gender,
                'product_image' => 'products/' . $filename, 
                'product_availability_status' => 'available',
                'product_stock_status' => ($stock > 0) ? 'inStock' : 'stockOut',
            ]);
        }
    }
}