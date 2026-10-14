<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    use HasFactory;

    protected $table = 'sale_details';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
        'discount' => 'float',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** Cantidad x precio menos el descuento (%) de la línea. */
    public function getSubtotalAttribute(): float
    {
        $gross = $this->quantity * $this->price;

        return round($gross - $gross * $this->discount / 100, 2);
    }
}
