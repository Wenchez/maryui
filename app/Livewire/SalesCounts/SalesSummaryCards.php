<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;
use App\Services\SaleReportService;
use Livewire\Attributes\On;

class SalesSummaryCards extends Component
{
    public $totalSales;
    public $totalIncome;
    public $avgTicket;

    public function mount(SaleReportService $sales)
    {
        $this->loadSummary($sales);
    }

    #[On('sales-filters-updated')]
    public function updateSummary(array $filters)
    {
        $sales = app(SaleReportService::class);
        $this->loadSummary($sales, $filters);
    }


    protected function loadSummary(SaleReportService $sales, array $filters = [])
    {
        $summary = $sales->getSalesSummary($filters);

        $this->totalSales  = $summary['total_sales'];
        $this->totalIncome = $summary['total_income'];
        $this->avgTicket   = $summary['avg_ticket'];
    }

    public function render()
    {
        return view('livewire.sales-counts.sales-summary-cards');
    }
}
