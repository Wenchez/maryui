<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return Product::select(
            'product_code AS Código',
            'product_name AS Producto',
            DB::raw("DATE_FORMAT(product_date,'%d/%m/%Y') AS FechaIngreso"),
            DB::raw('COALESCE(product_stock,0) AS Stock'),
            'product_price AS PrecioUnitario',
            DB::raw('(SELECT COALESCE(SUM(quantity),0) FROM sale_details WHERE sale_details.product_id = products.product_id) AS UnidadesVendidas'),
            DB::raw('(SELECT COALESCE(SUM(quantity * unit_price),0) FROM sale_details WHERE sale_details.product_id = products.product_id) AS TotalVendido')
        )->get();
    }

    public function headings(): array
    {
        return ['Código', 'Producto', 'Fecha Ingreso', 'Stock', 'Precio Unitario ($)', 'Unidades Vendidas', 'Total Vendido ($)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    public function columnWidths(): array
    {
        return ['A' => 15, 'B' => 30, 'C' => 15, 'D' => 10, 'E' => 15, 'F' => 15, 'G' => 15];
    }

    public function title(): string
    {
        return 'Productos';
    }
}
