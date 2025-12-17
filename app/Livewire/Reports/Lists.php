<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class Lists extends Component
{
    public $from_date;
    public $to_date;

    public $brands;
    public $categories;
    public $products;

    protected $listeners = ['report-filters-updated' => 'applyFilters'];

    public function mount(ReportService $reports)
    {
        $this->loadLists($reports);
    }

    public function applyFilters($filters)
    {
        $this->from_date = $filters['from_date'];
        $this->to_date   = $filters['to_date'];

        $this->loadLists(app(ReportService::class));
    }

    protected function loadLists(ReportService $reports)
    {
        $this->brands     = $reports->getTopBrands(5, $this->from_date, $this->to_date);
        $this->categories = $reports->getSalesByCategory(5, $this->from_date, $this->to_date);
        $this->products   = $reports->getTopProducts(5, $this->from_date, $this->to_date);
    }

    public function render()
    {
        return view('livewire.reports.lists');
    }
}
