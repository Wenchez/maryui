<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductType;
use Mary\Traits\Toast;

class ProductEditModal extends Component
{
    use Toast;
    use WithFileUploads;

    public $showModal = false;
    
    public $productId = null;

    public $brand_id;
    public $product_type_id;
    public $product_name;
    public $product_stock;
    public $product_price;
    public $product_gender;
    public $product_image;
    public $current_image_url;
    public $product_availability_status;

    public $brands = [];
    public $types = [];

    protected $listeners = ['editModal' => 'open'];

    protected $rules = [
        'brand_id' => 'required|exists:brands,brand_id',
        'product_type_id' => 'required|exists:product_types,product_type_id',
        'product_name' => 'required|string|max:100',
        'product_stock' => 'required|integer|min:0',
        'product_price' => 'required|numeric|min:0',
        'product_gender' => 'required|in:unisex,male,female',
        'product_image' => 'nullable|image|max:2048', // 2MB máx
        'product_availability_status' => 'required|in:available,discontinued',
    ];

    public function mount()
    {
        $this->current_image_url = asset('storage/products/default.png');
        $this->brands = Brand::all();
        $this->types = ProductType::all();
    }

    public function open($productId)
    {
        $this->resetValidation();

        $product = Product::findOrFail($productId);

        $imagePath = $product->product_image_path;

        $this->productId = $product->product_id;
        $this->brand_id = $product->brand_id;
        $this->product_type_id = $product->product_type_id;
        $this->product_name = $product->product_name;
        $this->product_stock = $product->product_stock;
        $this->product_price = $product->product_price;
        $this->product_gender = $product->product_gender;
        $this->product_availability_status = $product->product_availability_status;
        $this->current_image_url = asset($imagePath);

        $this->product_image = null;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset([
            'showModal',
            'productId',
            'brand_id',
            'product_type_id',
            'product_name',
            'product_stock',
            'product_price',
            'product_gender',
            'product_availability_status',
            'product_image',
        ]);
    }

    public function update()
    {
        $this->validate();

        $data = [
            'brand_id' => $this->brand_id,
            'product_type_id' => $this->product_type_id,
            'product_name' => $this->product_name,
            'product_stock' => $this->product_stock,
            'product_price' => $this->product_price,
            'product_gender' => $this->product_gender,
            'product_date' => now()->toDateString(),
        ];

        if ($this->product_image) {
            $data['product_image'] = $this->product_image;
        }

        Product::updateProduct($this->productId, $data);

        $this->success(
                'Producto actualizado correctamente.',
                position: 'toast-bottom toast-end',
                css: 'bg-pink-500 text-base-100',
                timeout: 2500
        );

        $this->dispatch('productUpdated',$this->productId);

        $this->showModal = false;

    }

    public function render()
    {
        return view('livewire.products.product-edit-modal');
    }
}
