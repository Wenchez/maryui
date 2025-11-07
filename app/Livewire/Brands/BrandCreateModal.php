<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use App\Models\Brand;


class BrandCreateModal extends Component
{
    public $brand_name;
    public $brand_description;
    public $showModal = false;
    
    protected $listeners = ['createBrand' => 'open'];

    protected $rules = [
        'brand_name' => 'required|string|max:40',
        'brand_description' => 'nullable|string|max:255',
    ];

    public function open()
    {
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate([
            'brand_name' => 'required|string|max:40',
            'brand_description' => 'nullable|string|max:255',
        ]);

        Brand::createBrand([
            'brand_name' => $this->brand_name,
            'brand_description' => $this->brand_description,
        ]);

        $this->showModal = false;
        $this->dispatch('brandUpdated');
    }

    public function render()
    {
        return view('livewire.brands.brand-create-modal');
    }
}
