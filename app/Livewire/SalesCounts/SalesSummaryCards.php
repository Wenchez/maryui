<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;
use App\Services\SaleReportService;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class SalesSummaryCards extends Component
{
    public bool $isCashier = false;

    public $totalSales;
    public $totalIncome;
    public $avgTicket;

    public function mount(SaleReportService $sales,bool $isCashier = false)
    {
        $this->isCashier = $isCashier;

        $filters = $this->isCashier
            ? ['user_id' => Auth::id()]
            : [];

        $this->loadSummary($sales, $filters);
    }

    #[On('sales-filters-updated')]
    public function updateSummary(array $filters)
    {
        if ($this->isCashier) {
            $filters['user_id'] = auth()->id();
            unset($filters['search']);
        }

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
