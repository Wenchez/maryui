<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Brand extends Model
{
    use HasFactory;

    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'brand_name',
        'brand_description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }

    public static function createBrand($data)
    {
        return self::create([
            'brand_name' => $data['brand_name'],
            'brand_description' => $data['brand_description'],
        ]);
    }

    public static function updateBrand($brandId, $data)
    {
        $brand = self::findOrFail($brandId);
        $brand->update($data);
        return $brand;
    }

    public static function deleteBrand($brandId)
    {
        $brand = self::findOrFail($brandId);

        try {
            return $brand->delete();
        } catch (QueryException $e) {
            throw new \Exception('No se puede eliminar la marca porque tiene productos asociados.');
        }
    }

    // Para los filtros por marca
    public static function getAllBrands()
    {
        return self::select('brand_id', 'brand_name')->orderBy('brand_name')->get();
    }
}