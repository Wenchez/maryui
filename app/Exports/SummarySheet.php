<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithStyles, WithColumnWidths, WithTitle, WithColumnFormatting
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;

class SummarySheet implements FromCollection, WithStyles, WithColumnWidths, WithTitle, WithColumnFormatting
{
    public function collection()
    {
        $data = collect();

        // =========================
        // 1️⃣ Ventas Mensuales
        // =========================
        $monthly = DB::table('sales as s')
            ->leftJoin('sale_details as sd','sd.sale_id','=','s.sale_id')
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
        $data->push(['Mes','Cantidad de Ventas','Ingresos ($)','Productos Vendidos','Promedio Ticket ($)']);
        foreach($monthly as $row){
            $data->push([
                $row->Mes,
                $row->Ventas,
                $row->Ingresos,
                $row->ProductosVendidos,
                round($row->PromedioTicket,2)
            ]);
        }
        $data->push([]); // fila vacía

        // =========================
        // 2️⃣ Top 5 Productos
        // =========================
        $topProducts = DB::table('sale_details as sd')
            ->join('products as p','p.product_id','=','sd.product_id')
            ->select('p.product_name', DB::raw('SUM(sd.quantity) AS UnidadesVendidas'))
            ->groupBy('p.product_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Productos']);
        $data->push(['Producto','Unidades Vendidas']);
        foreach($topProducts as $p){
            $data->push([$p->product_name, $p->UnidadesVendidas]);
        }
        $data->push([]);

        // =========================
        // 3️⃣ Top 5 Categorías
        // =========================
        $topCategories = DB::table('sale_details as sd')
            ->join('products as p','p.product_id','=','sd.product_id')
            ->join('product_types as pt','pt.product_type_id','=','p.product_type_id')
            ->select('pt.product_type_name', DB::raw('SUM(sd.quantity) AS UnidadesVendidas'))
            ->groupBy('pt.product_type_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Categorías']);
        $data->push(['Categoría','Unidades Vendidas']);
        foreach($topCategories as $c){
            $data->push([$c->product_type_name, $c->UnidadesVendidas]);
        }
        $data->push([]);

        // =========================
        // 4️⃣ Top 5 Marcas
        // =========================
        $topBrands = DB::table('sale_details as sd')
            ->join('products as p','p.product_id','=','sd.product_id')
            ->join('brands as b','b.brand_id','=','p.brand_id')
            ->select('b.brand_name', DB::raw('SUM(sd.quantity) AS UnidadesVendidas'))
            ->groupBy('b.brand_name')
            ->orderByDesc('UnidadesVendidas')
            ->limit(5)
            ->get();

        $data->push(['Top 5 Marcas']);
        $data->push(['Marca','Unidades Vendidas']);
        foreach($topBrands as $b){
            $data->push([$b->brand_name, $b->UnidadesVendidas]);
        }
        $data->push([]);

        // =========================
        // 5️⃣ Usuarios con más ventas
        // =========================
        $topUsers = DB::table('sales as s')
            ->join('users as u','u.user_id','=','s.user_id')
            ->select('u.name', DB::raw('SUM(s.sale_total) AS TotalVendido'))
            ->groupBy('u.name')
            ->orderByDesc('TotalVendido')
            ->limit(5)
            ->get();

        $data->push(['Usuarios con más ventas']);
        $data->push(['Usuario','Total Vendido ($)']);
        foreach($topUsers as $u){
            $data->push([$u->name, round($u->TotalVendido,2)]);
        }
        $data->push([]);

        // =========================
        // 6️⃣ Inventario
        // =========================
        $stockTotal = DB::table('products')->sum('product_stock');
        $productosAgotados = DB::table('products')->where('product_stock',0)->count();

        $data->push(['Inventario']);
        $data->push(['Descripción','Cantidad']);
        $data->push(['Stock Total Disponible', $stockTotal]);
        $data->push(['Productos Agotados', $productosAgotados]);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Poner títulos y encabezados en negrita
        $highestRow = $sheet->getHighestRow();
        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("A$row")->getValue();
            if (str_contains($cellValue,'Ventas Mensuales') ||
                str_contains($cellValue,'Top 5') ||
                str_contains($cellValue,'Usuarios') ||
                str_contains($cellValue,'Inventario')) {
                $sheet->getStyle("A$row:Z$row")->getFont()->setBold(true);
            }
            // Encabezados (segunda fila de cada sección)
            if ($row > 1 && str_contains($sheet->getCell("A".($row-1))->getValue(),'Ventas Mensuales') ||
                str_contains($sheet->getCell("A".($row-1))->getValue(),'Top 5') ||
                str_contains($sheet->getCell("A".($row-1))->getValue(),'Usuarios') ||
                str_contains($sheet->getCell("A".($row-1))->getValue(),'Inventario')) {
                $sheet->getStyle("A$row:Z$row")->getFont()->setBold(true);
            }
        }
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A'=>35,
            'B'=>20,
            'C'=>20,
            'D'=>20,
            'E'=>20
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
            'D' => NumberFormat::FORMAT_NUMBER,      // Unidades vendidas
            'E' => NumberFormat::FORMAT_NUMBER_00,   // Promedio ticket
        ];
    }
}
