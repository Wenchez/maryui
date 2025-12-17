<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class SummaryCards extends Component
{
    public $from_date;
    public $to_date;

    public $income;
    public $sales;
    public $incomeThisMonth;
    public $products;

    protected $listeners = ['report-filters-updated' => 'applyFilters'];

    public function mount(ReportService $reports)
    {
        $this->loadData($reports);
    }

    public function applyFilters($filters)
    {
        $this->from_date = $filters['from_date'];
        $this->to_date   = $filters['to_date'];

        $this->loadData(app(ReportService::class));
    }

    protected function loadData(ReportService $reports)
    {
        $this->income   = $reports->getTotalIncome($this->from_date, $this->to_date);
        $this->sales    = $reports->getSalesCount($this->from_date, $this->to_date);
        $this->incomeThisMonth = $reports->getIncomeCount($this->from_date, $this->to_date);
        $this->products = $reports->getTotalProductsSold($this->from_date, $this->to_date);
    }

    public function render()
    {
        return view('livewire.reports.summary-cards');
    }
}
