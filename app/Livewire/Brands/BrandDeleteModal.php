<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use App\Models\Brand;
use Mary\Traits\Toast;

class BrandDeleteModal extends Component
{
    use Toast;
    public $brandId;
    public $brandName;
    public $showModal = false;
    public $errorMessage = null;
    
    protected $listeners = ['deleteBrand' => 'open'];

     public function open($brandId)
    {
        $brand = Brand::findOrFail($brandId);

        $this->brandId = $brand->brand_id;
        $this->brandName = $brand->brand_name;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Brand::deleteBrand($this->brandId);
            $this->showModal = false;
            $this->success(
                'Marca eliminada correctamente!.',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
            $this->dispatch('brandUpdated');
            $this->errorMessage = null; // limpiar mensaje en caso de éxito
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage(); // guardar mensaje de error
            $this->error(
                'Error al eliminar la marca: ',
                position: 'toast-bottom toast-end',
                timeout: 2500
            );
        }
    }
    
    public function render()
    {
        return view('livewire.brands.brand-delete-modal');
    }
}
