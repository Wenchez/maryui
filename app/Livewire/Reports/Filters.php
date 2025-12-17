<?php

namespace App\Livewire\Reports;

use Livewire\Component;

class Filters extends Component
{
    public $from_date;
    public $to_date;
    public bool $open = false;

    public $dateConfig = [
        'locale' => 'es',
        'altInput' => true,
        'altFormat' => 'd/m/Y',
        'dateFormat' => 'Y-m-d',
    ];

    protected $queryString = [
        'from_date',
        'to_date',
    ];
    
    public function updatedFromDate()
    {
        $this->dispatchFilters();
    }

    public function updatedToDate()
    {
        $this->dispatchFilters();
    }

    public function clearFilters()
    {
        $this->reset(['from_date', 'to_date']);
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch(
            'report-filters-updated',
            filters: [
                'from_date' => $this->from_date,
                'to_date'   => $this->to_date,
            ]
        );
    }

    public function render()
    {
        return view('livewire.reports.filters');
    }
}
