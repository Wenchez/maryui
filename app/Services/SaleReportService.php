<?php

namespace App\Services;

use App\Models\Sale;

class SaleReportService
{
    /**
     * Obtener una venta con toda su información y detalles
     */
    public function getSaleById(int $saleId)
    {
        return Sale::with([
            'user',
            'details.product'
        ])->where('sale_id', $saleId)
            ->firstOrFail();
    }

    public function getSalesSummary(array $filters = []): array
    {
        $query = Sale::query();

        if (!empty($filters['from_date'])) {
            $query->whereDate('sale_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('sale_date', '<=', $filters['to_date']);
        }

        $totalSales  = $query->count();
        $totalIncome = $query->sum('sale_total');

        return [
            'total_sales'  => $totalSales,
            'total_income' => $totalIncome,
            'avg_ticket'   => $totalSales > 0
                ? round($totalIncome / $totalSales, 2)
                : 0,
        ];
    }

    /**
     * Obtener ventas con filtros opcionales
     */
    public function getSales(array $filters = [])
    {
        $query = Sale::with([
            'user',
            'details.product'
        ]);

        if (!empty($filters['from_date'])) {
            $query->whereDate('sale_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('sale_date', '<=', $filters['to_date']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('sale_reference', 'like', "%{$filters['search']}%")
                    ->orWhereHas('user', function ($u) use ($filters) {
                        $u->where('name', 'like', "%{$filters['search']}%");
                    });
            });
        }

        return $query
            ->orderBy('sale_date', 'desc');
    }

    /**
     * Formatear una venta para reporte (PDF / Vista / API)
     */
    public function formatSale(Sale $sale): array
    {
        return [
            'sale_id'        => $sale->sale_id,
            'reference'      => $sale->sale_reference,
            'sale_date'      => $sale->sale_date->format('d/m/Y H:i'),
            'processed_by'   => $sale->user->name ?? 'N/A',

            'subtotal'       => $sale->sale_subtotal,
            'tax'            => $sale->sale_tax,
            'total'          => $sale->sale_total,

            'items_count'    => $sale->details->count(),
            'products_count' => $sale->details->sum('quantity'),

            'products'       => $sale->details->map(function ($detail) {
                return [
                    'product_id'   => $detail->product->product_id,
                    'product_name' => $detail->product->product_name,
                    'quantity'     => $detail->quantity,
                    'unit_price'   => $detail->unit_price,
                    'line_total'   => $detail->line_total,
                ];
            }),
        ];
    }

    public function getFormattedSales(array $filters = [])
    {
        return $this->getSales($filters)
            ->map(fn($sale) => $this->formatSale($sale));
    }
}
