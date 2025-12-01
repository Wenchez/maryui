<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProductsViewGrid extends Component
{
    use WithPagination;

    public array $brands = [];
    public array $types = [];
    public array $genders = [];
    public string $search = '';

    protected $paginationTheme = 'tailwind';

    public $filters = [
        'brands' => [],
        'types' => [],
        'genders' => [],
        'search' => '',
    ];

    public function updateFilters($filters)
    {
        $this->filters = array_merge($this->filters, $filters);
    }

    #[On('filters-updated')]
    public function applyFilters(array $filters)
    {
        $this->brands = $filters['brands'] ?? [];
        $this->types = $filters['types'] ?? [];
        $this->genders = $filters['genders'] ?? [];
        $this->search = $filters['search'] ?? '';

        $this->resetPage(); // Descomenta si usas paginación
    }

    #[On('product-added')]
    public function handleProductAdded($productData)
    {
        $this->dispatch('add-product-to-sale', $productData);
    }

    #[On('product-updated')]
    public function refresh()
    {
        // Nada — Livewire re-renderiza automáticamente
    }

    public function getProductsProperty()
    {
        $brands = $this->brands;
        $types = $this->types;
        $genders = $this->genders;
        $search = $this->search;

        return Product::query()
            ->when($search, fn($q, $s) => $q->where('product_name', 'like', "%{$s}%"))
            ->when($brands, fn($q, $b) => $q->whereIn('brand_id', $b))
            ->when($types, fn($q, $t) => $q->whereIn('product_type_id', $t))
            ->when($genders, fn($q, $g) => $q->whereIn('product_gender', $g))
            ->with(['brand', 'productType'])
            ->paginate(12); 
    }

    public function render()
    {
        return view('livewire.products.products-view-grid', [
            'products' => $this->products,
        ]);
    }
}
