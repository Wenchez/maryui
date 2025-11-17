<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class Lists extends Component
{
    public $brands;
    public $categories;
    public $users;
    public $products;

    public function mount(ReportService $reports)
    {
        $this->brands = $reports->getTopBrands();
        $this->categories = $reports->getSalesByCategory();
        $this->products = $reports->getTopProducts();
    }

    public function render()
    {
        return view('livewire.reports.lists');
    }
}
