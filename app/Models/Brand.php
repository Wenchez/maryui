<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'brand_name',
        'brand_description',
    ];

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
        return $brand->delete();
    }

    /* public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    } */
}