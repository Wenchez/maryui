<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection()
    {
        return User::select(
            'name',
            'email',
            DB::raw('(SELECT COUNT(*) FROM sales WHERE sales.user_id = users.user_id) AS VentasRealizadas'),
            DB::raw('(SELECT COALESCE(SUM(sale_total),0) FROM sales WHERE sales.user_id = users.user_id) AS TotalVendido')
        )->get();
    }

    public function headings(): array
    {
        return ['Nombre', 'Correo Electrónico', 'Ventas Realizadas', 'Total Vendido ($)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 35, 'C' => 20, 'D' => 20];
    }

    public function title(): string
    {
        return 'Usuarios';
    }
}
