<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return Sale::select(
            DB::raw("DATE_FORMAT(sale_date,'%d/%m/%Y %H:%i') AS Fecha"),
            'sale_reference AS Referencia',
            DB::raw("(SELECT name FROM users WHERE users.user_id = sales.user_id) AS Cajero"),
            'sale_subtotal AS Subtotal',
            'sale_tax AS IVA',
            'sale_total AS Total',
            DB::raw('(SELECT SUM(quantity) FROM sale_details WHERE sale_details.sale_id = sales.sale_id) AS ArticulosVendidos'),
            DB::raw('(SELECT COUNT(*) FROM sale_details WHERE sale_details.sale_id = sales.sale_id) AS ConceptosDistintos')
        )->get();
    }

    public function headings(): array
    {
        return ['Fecha', 'Referencia', 'Cajero', 'Subtotal ($)', 'IVA ($)', 'Total ($)', 'Artículos Vendidos', 'Cantidad de Conceptos'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    public function columnWidths(): array
    {
        return ['A' => 18, 'B' => 15, 'C' => 25, 'D' => 15, 'E' => 15, 'F' => 15, 'G' => 18, 'H' => 30];
    }

    public function title(): string
    {
        return 'Ventas';
    }
}
