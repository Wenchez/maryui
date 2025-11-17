<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithStyles,
    WithColumnWidths,
    WithTitle,
    WithColumnFormatting
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SummarySheet implements FromCollection, WithStyles, WithColumnWidths, WithTitle, WithColumnFormatting
{
    public function collection()
    {
        $data = collect();

        // =========================
        // 1️⃣ Ventas Mensuales
        // =========================
        $monthly = DB::table('sales as s')
            ->leftJoin('sale_details as sd', 'sd.sale_id', '=', 's.sale_id')
            ->select(
                DB::raw("DATE_FORMAT(s.sale_date,'%Y-%m') AS Mes"),
                DB::raw("COUNT(DISTINCT s.sale_id) AS Ventas"),
                DB::raw("SUM(s.sale_total) AS Ingresos"),
                DB::raw("COALESCE(SUM(sd.quantity),0) AS ProductosVendidos"),
                DB::raw("(SUM(s.sale_total)/COUNT(DISTINCT s.sale_id)) AS PromedioTicket")
            )
            ->groupBy(DB::raw("DATE_FORMAT(s.sale_date,'%Y-%m')"))
            ->orderBy('Mes')
            ->get();

        $data->push(['Ventas Mensuales']);
        $data->push(['Mes', 'Cantidad de Ventas', 'Ingresos ($)', 'Productos Vendidos', 'Promedio Ticket ($)']);
        foreach ($monthly as $row) {
            $data->push([
                $row->Mes,
                $row->Ventas,
                round($row->Ingresos, 2),
                $row->ProductosVendidos,
                round($row->PromedioTicket, 2)
            ]);
        }
        $data->push([]);

        // =========================
        // 2️⃣ Top 5 Productos
        // =========================
        $topProducts = DB::table('sale_details as sd')
            ->join('products as p', 'p.product_id', '=', 'sd.product_id')
            ->select(
                'p.product_name',
                DB::raw('SUM(sd.quantity) AS UnidadesVendidas'),
                DB::raw('SUM(sd.quantity * sd.unit_price) AS IngresosTotales')
            )
            ->groupBy('p.product_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Productos']);
        $data->push(['Producto', 'Unidades Vendidas', 'Ingresos Totales ($)']);
        foreach ($topProducts as $p) {
            $data->push([
                $p->product_name,
                $p->UnidadesVendidas,
                round($p->IngresosTotales, 2)
            ]);
        }
        $data->push([]);

        // =========================
        // 3️⃣ Top 5 Categorías
        // =========================
        $topCategories = DB::table('sale_details as sd')
            ->join('products as p', 'p.product_id', '=', 'sd.product_id')
            ->join('product_types as pt', 'pt.product_type_id', '=', 'p.product_type_id')
            ->select(
                'pt.product_type_name',
                DB::raw('SUM(sd.quantity) AS UnidadesVendidas'),
                DB::raw('SUM(sd.quantity * sd.unit_price) AS IngresosTotales')
            )
            ->groupBy('pt.product_type_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Categorías']);
        $data->push(['Categoría', 'Unidades Vendidas', 'Ingresos Totales ($)']);
        foreach ($topCategories as $c) {
            $data->push([
                $c->product_type_name,
                $c->UnidadesVendidas,
                round($c->IngresosTotales, 2)
            ]);
        }
        $data->push([]);

        // =========================
        // 4️⃣ Top 5 Marcas
        // =========================
        $topBrands = DB::table('sale_details as sd')
            ->join('products as p', 'p.product_id', '=', 'sd.product_id')
            ->join('brands as b', 'b.brand_id', '=', 'p.brand_id')
            ->select(
                'b.brand_name',
                DB::raw('SUM(sd.quantity) AS UnidadesVendidas'),
                DB::raw('SUM(sd.quantity * sd.unit_price) AS IngresosTotales')
            )
            ->groupBy('b.brand_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Marcas']);
        $data->push(['Marca', 'Unidades Vendidas', 'Ingresos Totales ($)']);
        foreach ($topBrands as $b) {
            $data->push([
                $b->brand_name,
                $b->UnidadesVendidas,
                round($b->IngresosTotales, 2)
            ]);
        }
        $data->push([]);

        // =========================
        // 5️⃣ Usuarios con más ventas
        // =========================
        $topUsers = DB::table('sales as s')
            ->join('users as u', 'u.user_id', '=', 's.user_id')
            ->select('u.name', DB::raw('SUM(s.sale_total) AS TotalVendido'))
            ->groupBy('u.name')
            ->orderByDesc('TotalVendido')
            ->limit(5)
            ->get();

        $data->push(['Usuarios con más ventas']);
        $data->push(['Usuario', 'Total Vendido ($)']);
        foreach ($topUsers as $u) {
            $data->push([$u->name, round($u->TotalVendido, 2)]);
        }
        $data->push([]);

        // =========================
        // 6️⃣ Inventario Mejorado
        // =========================
        $stockTotal = DB::table('products')->sum('product_stock');
        $productosAgotados = DB::table('products')->where('product_stock', 0)->count();
        $productosBajoStock = DB::table('products')->where('product_stock', '<', 5)->count();

        $data->push(['Inventario']);
        $data->push(['Métrica', 'Cantidad', 'Detalle']);
        $data->push(['Productos totales con stock', $stockTotal, 'Suma de todos los productos con stock > 0']);
        $data->push(['Productos agotados', $productosAgotados, 'Productos cuyo stock = 0']);
        $data->push(['Productos bajos en stock (<5)', $productosBajoStock, 'Productos con stock menor a 5 unidades']);

        $productosCriticos = DB::table('products')
            ->leftJoin('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->leftJoin('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
            ->select(
                DB::raw('COALESCE(products.product_name,"Sin Producto") as Producto'),
                DB::raw('COALESCE(product_types.product_type_name,"Sin Categoría") as Categoria'),
                DB::raw('COALESCE(brands.brand_name,"Sin Marca") as Marca'),
                DB::raw('COALESCE(products.product_stock,0) as Stock')
            )
            ->where('products.product_stock', '<', 5)
            ->orderBy('products.product_stock', 'asc')
            ->get();

        if ($productosCriticos->count() > 0) {
            $data->push([]);
            $data->push(['Productos críticos (agotados y bajo stock)']);
            $data->push(['Producto', 'Categoría', 'Marca', 'Stock']);
            foreach ($productosCriticos as $p) {
                $data->push([
                    $p->Producto,
                    $p->Categoria,
                    $p->Marca,
                    (int)$p->Stock
                ]);
            }
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("A$row")->getValue();
            if (
                str_contains($cellValue, 'Ventas Mensuales') ||
                str_contains($cellValue, 'Top 5') ||
                str_contains($cellValue, 'Usuarios') ||
                str_contains($cellValue, 'Inventario') ||
                str_contains($cellValue, 'Productos críticos')
            ) {
                $sheet->getStyle("A$row:Z$row")->getFont()->setBold(true);
            }
        }
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20
        ];
    }

    public function title(): string
    {
        return 'Resumen General';
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,      // Cantidades
            'C' => NumberFormat::FORMAT_NUMBER_00,   // Ingresos
            'D' => NumberFormat::FORMAT_NUMBER,      // Unidades vendidas / Stock
            'E' => NumberFormat::FORMAT_NUMBER_00,   // Promedio ticket o ingresos
        ];
    }
}
