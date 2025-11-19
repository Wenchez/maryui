<?php

namespace App\Livewire\Brands;

use Livewire\Component;

class Index extends Component
{
    public bool $accessDenied = false;

    public function mount()
    {
        if (auth()->user()->role !== 'manager') {
            $this->accessDenied = true;
        }
    }

    public function render()
    {
        if ($this->accessDenied) {
            return view('livewire.access-denied')
                ->layout('components.layouts.app', ['title' => 'Acceso denegado']);
        }

        return view('livewire.brands.index')
            ->layout('components.layouts.app', ['title' => 'Marcas']);
    }
}
