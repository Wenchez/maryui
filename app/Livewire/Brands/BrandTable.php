<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;

class BrandTable extends Component
{
    use WithPagination;

    public int $perPage = 5;

    public array $sortBy = ['column' => 'brand_name', 'direction' => 'asc'];

    protected $listeners = ['brandUpdated' => '$refresh']; // refresca tabla al editar

    public function sort($column)
    {
        if ($this->sortBy['column'] === $column) {
            $this->sortBy['direction'] = $this->sortBy['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy['column'] = $column;
            $this->sortBy['direction'] = 'asc';
        }
    }

    public function createBrand()
    {
        $this->dispatch('createBrand')->to('brands.brand-create-modal');
    }

    public function editBrand($brandId)
    {
        $this->dispatch('editBrand', brandId: $brandId)->to('brands.brand-edit-modal');
    }

    public function deleteBrand($brandId)
    {
        $this->dispatch('deleteBrand', brandId: $brandId)->to('brands.brand-delete-modal');
    }

    public function render()
    {
        $brands = Brand::query()
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate($this->perPage);

        $headers = [
            ['key' => 'brand_id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'brand_name', 'label' => 'Nombre'],
            ['key' => 'brand_description', 'label' => 'Descripción'],
            ['key' => 'actions', 'label' => 'Acciones', 'sortable' => false],
        ];

        return view('livewire.brands.brand-table', [
            'brands' => $brands,
            'headers' => $headers
        ]);
    }
}
