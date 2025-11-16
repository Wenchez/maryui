<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;

    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'sale_date',
        'user_id',
        'sale_subtotal',
        'sale_tax',
        'sale_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'sale_id');
    }

    public function calculateTotals()
    {
        $subtotal = $this->details->sum(function ($detail) {
            return $detail->quantity * $detail->unit_price;
        });

        $tax = $subtotal * 0.16;
        $total = $subtotal + $tax;

        $this->sale_subtotal = round($subtotal, 2);
        $this->sale_tax = round($tax, 2);
        $this->sale_total = round($total, 2);
    }

    public static function createWithDetails(array $data, array $details)
    {
        return DB::transaction(function () use ($data, $details) {
            $sale = self::create($data);

            foreach ($details as $detail) {
                $sale->details()->create($detail);
            }

            $sale->calculateTotals();
            $sale->save();

            return $sale;
        });
    }

    public function addProduct($productId, $quantity = 1, $unitPrice = null)
    {
        $detail = $this->details()->where('product_id', $productId)->first();

        if ($detail) {
            $detail->quantity += $quantity;
            $detail->save();
        } else {
            $this->details()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice ?? Product::find($productId)->product_price,
            ]);
        }

        $this->refreshTotals();
    }

    public function removeProduct($productId)
    {
        $this->details()->where('product_id', $productId)->delete();
        $this->refreshTotals();
    }

    public function refreshTotals()
    {
        $this->load('details');
        $this->calculateTotals();
        $this->save();
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->sale_total, 2);
    }

    protected static function booted()
    {
        static::creating(function ($sale) {
            $sale->sale_reference = self::generateReference();
        });
    }

    public static function generateReference()
    {
        $prefix = 'XB';
        $datePart = now()->format('dmY');

        $lastSale = self::whereDate('sale_date', now()->toDateString())
            ->orderBy('sale_id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastSale && preg_match('/(\d{4})$/', $lastSale->sale_reference, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        return sprintf('%s-%s-%04d', $prefix, $datePart, $nextNumber);
    }
}
