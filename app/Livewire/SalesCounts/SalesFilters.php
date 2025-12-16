<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;

class SalesFilters extends Component
{
    public $from_date;
    public $to_date;
    public $search = '';
    public bool $open = false;

    protected $queryString = [
        'from_date',
        'to_date',
        'search',
    ];
    
    public function updatedFromDate()
    {
        $this->dispatchFilters();
    }

    public function updatedToDate()
    {
        $this->dispatchFilters();
    }

    public function updatedSearch()
    {
        $this->dispatchFilters();
    }

    public function clearFilters()
    {
        $this->reset(['from_date', 'to_date', 'search']);
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch(
            'sales-filters-updated',
            filters: [
                'from_date' => $this->from_date,
                'to_date'   => $this->to_date,
                'search'    => $this->search,
            ]
        );
    }

    public function render()
    {
        return view('livewire.sales-counts.sales-filters');
    }
}
