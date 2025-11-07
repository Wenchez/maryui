<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.product-types.index')
        ->layout('components.layouts.app', ['title' => 'Categorías']);
    }
}