<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Mary\Traits\Toast;

class ProductCreateModal extends Component
{
    use Toast;
    use WithFileUploads;

    public $showModal = false;

    public $brand_id;
    public $product_type_id;
    public $product_name;
    public $product_stock;
    public $product_price;
    public $product_gender = 'unisex';
    public $product_image;

    public $brands = [];
    public $types = [];

    protected $rules = [
        'brand_id' => 'required|exists:brands,brand_id',
        'product_type_id' => 'required|exists:product_types,product_type_id',
        'product_name' => 'required|string|max:100',
        'product_stock' => 'required|integer|min:0',
        'product_price' => 'required|numeric|min:0',
        'product_gender' => 'required|in:unisex,male,female',
        'product_image' => 'nullable|image|max:2048', // 2MB máx
    ];

    public function mount()
    {
        $this->brands = Brand::all();
        $this->types = ProductType::all();
    }

    public function open()
    {
        // Resetear campos al abrir modal
        $this->resetExcept(['brands', 'types']);
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        Product::createProduct([
            'brand_id' => $this->brand_id,
            'product_type_id' => $this->product_type_id,
            'product_name' => $this->product_name,
            'product_stock' => $this->product_stock,
            'product_price' => $this->product_price,
            'product_gender' => $this->product_gender,
            'product_image' => $this->product_image,
            'product_date' => now()->toDateString(),
        ]);

        $this->showModal = false;

        $this->success(
                'Producto creado correctamente.',
                position: 'toast-bottom toast-end',
                css: 'bg-pink-500 text-base-100',
                timeout: 2500
        );

        $this->dispatch('productUpdated');
    }

    public function render()
    {
        return view('livewire.products.product-create-modal');
    }
}
