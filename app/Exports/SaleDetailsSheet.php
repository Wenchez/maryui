<?php

namespace App\Exports;

use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleDetailsSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return SaleDetail::select(
            DB::raw('sale_details.sale_id AS Venta'),
            DB::raw("(SELECT DATE_FORMAT(sales.sale_date,'%d/%m/%Y %H:%i') FROM sales WHERE sales.sale_id = sale_details.sale_id) AS Fecha"),
            DB::raw("(SELECT product_code FROM products WHERE products.product_id = sale_details.product_id) AS Código"),
            DB::raw("(SELECT product_name FROM products WHERE products.product_id = sale_details.product_id) AS Producto"),
            'quantity AS Cantidad',
            'unit_price AS PrecioUnitario',
            DB::raw('(quantity * unit_price) AS TotalLinea')
        )->get();
    }

    public function headings(): array
    {
        return ['Venta', 'Fecha', 'Código', 'Producto', 'Cantidad', 'Precio Unitario ($)', 'Total Línea ($)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    public function columnWidths(): array
    {
        return ['A' => 10, 'B' => 18, 'C' => 15, 'D' => 30, 'E' => 10, 'F' => 15, 'G' => 15];
    }

    public function title(): string
    {
        return 'Detalle de Ventas';
    }
}
