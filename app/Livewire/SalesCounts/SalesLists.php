<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\SaleReportService;
use Livewire\Attributes\On;

class SalesLists extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public array $filters = [];

    #[On('sales-filters-updated')]
    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function render(SaleReportService $sales)
    {
        return view('livewire.sales-counts.sales-lists', [
            'sales' => $sales->getSales($this->filters)->paginate(10),
        ]);
    }
}
