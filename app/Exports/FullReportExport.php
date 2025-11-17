<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SummarySheet(),
            new UsersSheet(),
            new CategoriesSheet(),
            new BrandsSheet(),
            new ProductsSheet(),
            new SaleDetailsSheet(),
            new SalesSheet(),
        ];
    }
}
