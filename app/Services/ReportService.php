<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReportService
{
protected function dateFilter($query, $from, $to, $column = 'sale_date')
    {
        if ($from && $to) {
            $query->whereBetween($column, [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ]);
        } elseif ($from) {
            $query->where($column, '>=', Carbon::parse($from)->startOfDay());
        } elseif ($to) {
            $query->where($column, '<=', Carbon::parse($to)->endOfDay());
        }

        return $query;
    }


    /* ===============================
     * 1. TARJETAS
     * =============================== */

    public function getTotalIncome($from = null, $to = null)
    {
        $query = Sale::query();
        $this->dateFilter($query, $from, $to);
        return $query->sum('sale_total');
    }

    public function getSalesCount($from = null, $to = null)
    {
        $query = Sale::query();
        $this->dateFilter($query, $from, $to);

        return $query->count();
    }

    public function getTotalProductsSold($from = null, $to = null)
    {
        $query = DB::table('sale_details')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.sale_id');

        $this->dateFilter($query, $from, $to, 'sales.sale_date');

        return $query->sum('sale_details.quantity');
    }

    public function getIncomeCount($from = null, $to = null)
    {
        $query = Sale::query();
        $this->dateFilter($query, $from, $to);

        return $query->sum('sale_total');
    }

    /* ===============================
     * 2. GRÁFICOS
     * =============================== */

    public function getIncomeByMonth($from = null, $to = null)
    {
        $query = Sale::selectRaw("
            MONTH(sale_date) as month,
            SUM(sale_total) as total
        ");

        $this->dateFilter($query, $from, $to);

        return $query
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }

    public function getTopUsers($from = null, $to = null)
    {
        $query = DB::table('users')
            ->join('sales', 'users.user_id', '=', 'sales.user_id');

        $this->dateFilter($query, $from, $to, 'sales.sale_date');

        return $query
            ->select(
                'users.user_id',
                'users.name',
                DB::raw('COUNT(sales.sale_id) AS total_sales'),
                DB::raw('SUM(sales.sale_total) AS total_income_generated')
            )
            ->groupBy('users.user_id', 'users.name')
            ->orderByDesc('total_income_generated')
            ->limit(5)
            ->get();
    }

    /* ===============================
     * 3. LISTAS
     * =============================== */

    public function getTopProducts($limit = 5, $from = null, $to = null)
    {
        $query = DB::table('products')
            ->join('sale_details', 'products.product_id', '=', 'sale_details.product_id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.sale_id');

        $this->dateFilter($query, $from, $to, 'sales.sale_date');

        return $query
            ->select(
                'products.product_id',
                'products.product_name',
                DB::raw('SUM(sale_details.quantity) as total_sold'),
                DB::raw('SUM(sale_details.quantity * sale_details.unit_price) as revenue')
            )
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getSalesByCategory($limit = 5, $from = null, $to = null)
    {
        $query = DB::table('product_types')
            ->join('products', 'product_types.product_type_id', '=', 'products.product_type_id')
            ->join('sale_details', 'products.product_id', '=', 'sale_details.product_id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.sale_id');

        $this->dateFilter($query, $from, $to, 'sales.sale_date');

        return $query
            ->select(
                'product_types.product_type_id',
                'product_types.product_type_name',
                DB::raw('SUM(sale_details.quantity) as total_sold'),
                DB::raw('SUM(sale_details.quantity * sale_details.unit_price) as revenue')
            )
            ->groupBy(
                'product_types.product_type_id',
                'product_types.product_type_name'
            )
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getTopBrands($limit = 5, $from = null, $to = null)
    {
        $query = DB::table('brands as b')
            ->join('products as p', 'b.brand_id', '=', 'p.brand_id')
            ->join('sale_details as sd', 'p.product_id', '=', 'sd.product_id')
            ->join('sales as s', 'sd.sale_id', '=', 's.sale_id');

        $this->dateFilter($query, $from, $to, 's.sale_date');

        return $query
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
