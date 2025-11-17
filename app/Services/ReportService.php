<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /* ============================================================
     * 1. TARJETAS DE RESUMEN
     * ============================================================ */

    // Total vendido en los últimos 30 días
    public function getTotalIncomeLast30Days()
    {
        return Sale::whereBetween('sale_date', [now()->subDays(30), now()])
            ->sum('sale_total');
    }

    // Total de ventas realizadas este mes
    public function getSalesCountThisMonth()
    {
        return Sale::whereMonth('sale_date', now())
            ->count();
    }

    // Ingreso total de este mes
    public function getTotalIncomeThisMonth()
    {
        return Sale::whereMonth('sale_date', now())
            ->sum('sale_total');
    }

    // Cantidad total de productos vendidos este mes
    public function getTotalProductsSoldThisMonth()
    {
        return DB::table('sale_details')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.sale_id')
            ->whereMonth('sales.sale_date', now())
            ->sum('sale_details.quantity');
    }

    /* ============================================================
     * 2. GRÁFICOS
     * ============================================================ */

    public function getIncomeByMonth()
    {
        return Sale::selectRaw("MONTH(sale_date) as month, SUM(sale_total) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }

    public function getTopUsers()
    {
        return DB::table('users')
            ->join('sales', 'users.user_id', '=', 'sales.user_id')
            ->select(
                'users.user_id',
                'users.name',
                DB::raw('COUNT(sales.sale_id) AS total_sales'),
                DB::raw('SUM(sales.sale_total) AS total_income_generated')
            )
            ->groupBy('users.user_id', 'users.name')
            ->orderBy('total_income_generated', 'desc')
            ->limit(5)
            ->get();
    }

    /* ============================================================
     * 3. LISTAS
     * ============================================================ */

    public function getSalesByCategory($limit = 5)
    {
        return ProductType::select(
            'product_types.product_type_id',
            'product_types.product_type_name',
            DB::raw('SUM(sale_details.quantity) as total_sold'),
            DB::raw('SUM(sale_details.quantity * sale_details.unit_price) as revenue')
        )
            ->join('products', 'product_types.product_type_id', '=', 'products.product_type_id')
            ->join('sale_details', 'products.product_id', '=', 'sale_details.product_id')
            ->groupBy('product_types.product_type_id', 'product_types.product_type_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getTopProducts($limit = 5)
    {
        return DB::table('products')
            ->join('sale_details', 'products.product_id', '=', 'sale_details.product_id')
            ->select(
                'products.product_id',
                'products.product_name',
                DB::raw('SUM(sale_details.quantity) as total_sold'),
                DB::raw('SUM(sale_details.quantity * sale_details.unit_price) as revenue')
            )
            ->groupBy(
                'products.product_id',
                'products.product_name'
            )
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getTopBrands($limit = 5)
    {
        return DB::table('brands as b')
            ->join('products as p', 'b.brand_id', '=', 'p.brand_id')
            ->join('sale_details as sd', 'p.product_id', '=', 'sd.product_id')
            ->select(
                'b.brand_id',
                'b.brand_name',
                DB::raw('SUM(sd.quantity) as total_sold'),
                DB::raw('SUM(sd.quantity * sd.unit_price) as revenue')
            )
            ->groupBy('b.brand_id', 'b.brand_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
