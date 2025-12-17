<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Registro de ventas')]
class Index extends Component
{
    public bool $isCashier= false;

    public function mount()
    {
        if (auth()->user()->role !== 'manager') {
            $this->isCashier = true;
        }
    }

    public function render()
    {
        return view('livewire.sales-counts.index');
    }
}
