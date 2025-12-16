<?php

namespace App\Livewire\SalesCounts;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Registro de ventas')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.sales-counts.index');
    }
}
