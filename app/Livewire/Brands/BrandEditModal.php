<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use App\Models\Brand;
use Mary\Traits\Toast;

class BrandEditModal extends Component
{
    use Toast;
    public $brandId;
    public $brand_name;
    public $brand_description;
    public $showModal = false;
    
    protected $listeners = ['editBrand' => 'open'];

    protected $rules = [
        'brand_name' => 'required|string|max:40',
        'brand_description' => 'nullable|string|max:255',
    ];

    public function open($brandId)
    {
        $brand = Brand::findOrFail($brandId);

        $this->brandId = $brand->brand_id;
        $this->brand_name = $brand->brand_name;
        $this->brand_description = $brand->brand_description;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'brand_name' => 'required|string|max:40',
            'brand_description' => 'nullable|string|max:255',
        ]);

        Brand::updateBrand($this->brandId, [
            'brand_name' => $this->brand_name,
            'brand_description' => $this->brand_description,
        ]);

        $this->success(
                'Marca actualizada correctamente!',
                position: 'toast-bottom toast-end',
                css: 'bg-pink-500 text-base-100',
                timeout: 2500
        );

        $this->showModal = false;
        $this->dispatch('brandUpdated');
    }

    public function render()
    {
        return view('livewire.brands.brand-edit-modal');
    }
}
