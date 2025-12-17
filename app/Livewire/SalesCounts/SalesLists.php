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

    public bool $isCashier = false;
    public array $filters = [];

    public function mount(bool $isCashier = false)
    {
        $this->isCashier = $isCashier;

        if ($this->isCashier) {
            $this->filters['user_id'] = auth()->id();
        }
    }

    #[On('sales-filters-updated')]
    public function updateFilters($filters)
    {
        if ($this->isCashier) {
            $filters['user_id'] = auth()->id();
            unset($filters['search']);
        }

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
