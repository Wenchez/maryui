<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class ProductType extends Model
{
    /** @use HasFactory<\Database\Factories\ProductTypeFactory> */
    use HasFactory;

    protected $primaryKey = 'product_type_id';

    protected $fillable = [
        'product_type_name',
        'product_type_description',
    ];

    public static function createProductType($data)
    {
        return self::create([
            'product_type_name' => $data['product_type_name'],
            'product_type_description' => $data['product_type_description'],
        ]);
    }

    public static function updateProductType($product_typeId, $data)
    {
        $product_type = self::findOrFail($product_typeId);
        $product_type->update($data);
        return $product_type;
    }

    public static function deleteProductType($product_typeId)
    {
        $product_type = self::findOrFail($product_typeId);
        try {
            return $product_type->delete();
        } catch (QueryException $e) {
            throw new \Exception('No se puede eliminar la categoría porque tiene productos asociados.');
        }
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id', 'product_type_id');
    }
}
