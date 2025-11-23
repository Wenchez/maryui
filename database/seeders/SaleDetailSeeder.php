<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SaleDetailSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Almacena el último número de referencia usado por fecha simulada.
        $dailyCounters = [];

        // 1. Obtener datos de productos (usando keyBy para un acceso rápido)
        $products = Product::select('product_id', 'product_price', 'product_stock')
            ->get()
            ->keyBy('product_id');

        $productPrices = $products->map(fn($p) => $p->product_price);
        $userIds = User::pluck('user_id')->toArray();

        if ($products->isEmpty() || empty($userIds)) {
            echo "Advertencia: No hay suficientes datos (productos o usuarios) para generar ventas.\n";
            return;
        }

        $numberOfSales = 50;
        $productIds = $products->keys();

        for ($i = 0; $i < $numberOfSales; $i++) {
            $start = Carbon::create(2025, 1, 1);
            $end = Carbon::create(2025, 11, 30);

            $saleDate = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp));

            // Extraer la clave de fecha para el contador: DMY
            $dateKey = $saleDate->format('dmY');

            $saleData = [
                'sale_date' => $saleDate,
                'user_id' => $faker->randomElement($userIds),
            ];

            $selectedProductIds = $productIds->shuffle()->take(rand(1, 4));
            $details = [];

            // Generar detalles y verificar stock localmente
            foreach ($selectedProductIds as $productId) {
                $product = $products->get($productId);

                // Asegurar que solo vendemos el stock disponible
                $maxQuantity = min(rand(1, 3), $product->product_stock);

                if ($maxQuantity > 0) {
                    $price = $productPrices[$productId];
                    $quantity = $maxQuantity;

                    $details[] = [
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                    ];
                }
            }

            // Si no se pudo generar ningún detalle (stock agotado o aleatorio), saltar
            if (empty($details)) {
                continue;
            }

            // Lógica de transacción directa (simulando processSale)
            DB::transaction(function () use ($saleData, $details, &$products, $dateKey, &$dailyCounters) {

                // 1. Generación de Referencia ÚNICA basada en el contador LOCAL del seeder
                if (!isset($dailyCounters[$dateKey])) {
                    $dailyCounters[$dateKey] = 0;
                }
                $dailyCounters[$dateKey]++;

                $prefix = 'XB';
                // Generar la referencia usando el contador local para evitar duplicados
                $saleData['sale_reference'] = sprintf('%s-%s-%04d', $prefix, $dateKey, $dailyCounters[$dateKey]);

                // 2. Crear Venta
                $sale = new Sale($saleData);
                $sale->save();

                // 3. Crear Detalles y Actualizar Stock en DB
                foreach ($details as $item) {
                    $sale->details()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);

                    // Actualiza el stock en la base de datos usando decrement (más eficiente)
                    Product::where('product_id', $item['product_id'])
                        ->decrement('product_stock', $item['quantity']);

                    // Actualiza la colección local $products para el siguiente ciclo
                    $product = $products->get($item['product_id']);
                    if ($product) {
                        $product->product_stock -= $item['quantity'];
                    }
                }

                // 4. Calcular Totales y Guardar
                // Forzar la carga de los detalles para que calculateTotals funcione
                $sale->load('details');
                $sale->calculateTotals();
                $sale->save();
            });
        }
    }
}
