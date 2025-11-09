<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Brand;
use App\Models\ProductType;

class ProductSaleFilters extends Component
{
    public array $selectedBrands = [];
    public array $selectedTypes = [];
    public array $selectedGenders = [];
    public string $search = '';

    public array $availableBrands = [];
    public array $availableTypes = [];
    public array $availableGenders = ['male' => 'Masculino', 'female' => 'Femenino', 'unisex' => 'Unisex'];

    public function mount($filters = [])
    {
        $this->selectedBrands = array_map('strval', $filters['brands'] ?? []);
        $this->selectedTypes = array_map('strval', $filters['types'] ?? []);
        $this->selectedGenders = array_map('strval', $filters['genders'] ?? []); 
        $this->search = $filters['search'] ?? '';

        $this->availableBrands = Brand::orderBy('brand_name')->pluck('brand_name', 'brand_id')->toArray();
        $this->availableTypes  = ProductType::orderBy('product_type_name')->pluck('product_type_name', 'product_type_id')->toArray();
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['selectedBrands', 'selectedTypes', 'selectedGenders', 'search'])) {
            $this->sendFilters();
        }
    }

    public function sendFilters()
    {
        $brands = array_map('intval', $this->selectedBrands);
        $types = array_map('intval', $this->selectedTypes);
        
        $genders = $this->selectedGenders;

        $this->dispatch('filters-updated', [
            'brands' => $brands,
            'types' => $types,
            'genders' => $genders,
            'search' => $this->search,
        ])->to(ProductsSaleGrid::class);
    }

    public function clearFilters() {
        $this->selectedBrands = [];
        $this->selectedTypes = [];
        $this->selectedGenders = [];
        $this->search = '';
        $this->sendFilters();
    }
    public function clearBrands() { $this->selectedBrands = []; $this->sendFilters(); }
    public function clearTypes() { $this->selectedTypes = []; $this->sendFilters(); }
    public function clearGenders() { $this->selectedGenders = []; $this->sendFilters(); }
    public function clearSearch() { $this->search = ''; $this->sendFilters(); }

    public function render()
    {
        return view('livewire.sales.product-sale-filters');
    }
}
