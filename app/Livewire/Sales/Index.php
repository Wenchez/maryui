<?php

namespace App\Livewire\Sales;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.sales.index')
        ->layout('components.layouts.app', ['title' => 'Ventas']);
    }
}
