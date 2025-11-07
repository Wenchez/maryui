<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'brand_id',
        'product_type_id',
        'product_date',
        'product_code',
        'product_name',
        'product_stock',
        'product_price',
        'product_gender',
        'product_image',
        'product_availability_status',
        'product_stock_status',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'product_type_id');
    }

    public static function createProduct($data)
    {
        $data['product_code'] = self::generateProductCode();

        $imagePath = null;

        if (isset($data['product_image']) && $data['product_image']) {
            $extension = $data['product_image']->getClientOriginalExtension();

            $filename = self::generateImageFilename(
                $data['product_type_name'],
                $data['brand_name'],
                $data['product_code'],
                $data['product_name'],
                $extension
            );

            $imagePath = $data['product_image']->storeAs('products', $filename, 'public');
        }

        $data['product_image'] = $imagePath;
        
        return self::create([
            'brand_id' => $data->brand_id,
            'product_type_id' => $data->product_type_id,
            'product_date' => $data->product_date,
            'product_code' => $data->product_code,
            'product_name' => $data->product_name,
            'product_stock' => $data->product_stock,
            'product_price' => $data->product_price,
            'product_gender' => $data->product_gender ?? 'unisex',
            'product_image' => $data->product_image ?? null,
            'product_availability_status' => 'available',
            'product_stock_status' => ($data['product_stock'] > 0) ? 'inStock' : 'stockOut', 
        ]);
    }

    public static function updateProduct($productId, $data)
    {
        $product = self::findOrFail($productId);
        if (isset($data['product_image']) && $data['product_image']) {
            $data['product_image'] = self::handleImageUpdate($product, $data['product_image'], $data['product_name'] ?? null);
        }
        $product->update($data);
        return $product;
    }

    public static function deleteProduct($productId)
    {
        $product = self::findOrFail($productId);
        return $product->delete();
    }

    public static function generateProductCode()
    {
        $lastProduct = self::orderBy('product_id', 'desc')->first();

        if (!$lastProduct) {
            $number = 0;
        } else {
            $lastNumber = (int) str_replace('PROD_', '', $lastProduct->product_code);
            $number = $lastNumber + 1;
        }

        if ($number > 999) {
            throw new \Exception('Se alcanzó el límite máximo de productos (999).');
        }

        return 'PROD_' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public static function generateImageFilename($productTypeName, $brandName, $productCode, $productName, $extension)
    {
        $productTypeName = str_replace(' ', '_', $productTypeName);
        $brandName       = str_replace(' ', '_', $brandName);
        $productName     = str_replace(' ', '_', $productName);

        return "{$productCode}-{$productTypeName}-{$brandName}-{$productName}.{$extension}";
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->product_price, 2);
    }

    public function getGenderLabelAttribute()
    {
        return match($this->product_gender) {
            'male' => 'Masculino',
            'female' => 'Femenino',
            'unisex' => 'Unisex',
            default => 'Unisex',
        };
    }
    
    public function getProductImageUrlAttribute()
    {
        if ($this->product_image) {
            return asset('storage/' . $this->product_image);
        }
        return asset('images/default.png');
    }

    protected static function handleImageUpdate($product, $newImage, $newName = null)
    {
        if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
            Storage::disk('public')->delete($product->product_image);
        }

        $extension = $newImage->getClientOriginalExtension();

        $filename = self::generateImageFilename(
            $product->productType->type_name,
            $product->brand->brand_name,
            $product->product_code,
            $newName ?? $product->product_name,
            $extension
        );

        return $newImage->storeAs('products', $filename, 'public');
    }

    protected static function booted()
    {
        static::saving(function ($product) {
            $product->product_stock_status = ($product->product_stock <= 0) ? 'stockOut' : 'inStock';
            if ($product->product_stock < 0) {
                $product->product_stock = 0;
            }
        });
    }
}
