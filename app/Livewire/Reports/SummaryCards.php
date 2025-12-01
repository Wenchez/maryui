<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class SummaryCards extends Component
{
    public $incomeLast30;
    public $salesThisMonth;
    public $incomeThisMonth;
    public $productsSoldThisMonth;

    public function mount(ReportService $reports)
    {
        $this->incomeLast30 = $reports->getTotalIncomeLast30Days();
        $this->salesThisMonth = $reports->getSalesCountThisMonth();
        $this->incomeThisMonth = $reports->getTotalIncomeThisMonth();
        $this->productsSoldThisMonth = $reports->getTotalProductsSoldThisMonth();
    }

    public function render()
    {
        return view('livewire.reports.summary-cards');
    }
}

