<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BrandsSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return Brand::select(
            'brand_name AS Marca',
            DB::raw('(SELECT COUNT(*) FROM products WHERE products.brand_id = brands.brand_id) AS ProductosDisponibles'),
            DB::raw('(
                SELECT COALESCE(SUM(sd.quantity),0)
                FROM sale_details sd
                JOIN products p ON p.product_id = sd.product_id
                WHERE p.brand_id = brands.brand_id
            ) AS UnidadesVendidas'),
            DB::raw('(
                SELECT COALESCE(SUM(sd.quantity * sd.unit_price),0)
                FROM sale_details sd
                JOIN products p ON p.product_id = sd.product_id
                WHERE p.brand_id = brands.brand_id
            ) AS TotalVendido')
        )->get();
    }

    public function headings(): array
    {
        return ['Marca', 'Productos Disponibles', 'Unidades Vendidas', 'Total Vendido ($)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    public function columnWidths(): array
    {
        return ['A' => 25, 'B' => 20, 'C' => 20, 'D' => 20];
    }

    public function title(): string
    {
        return 'Marcas';
    }
}
