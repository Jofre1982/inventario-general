<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public const ACTIVE = 'ACTIVE';
    public const INACTIVE = 'DEACTIVATE';

    protected $fillable = [
        'code',
        'name',
        'stock',
        'min_stock',
        'image',
        'sell_price',
        'status',
        'category_id',
        'provider_id',
    ];

    protected $casts = [
        'stock' => 'integer',
        'min_stock' => 'integer',
        'sell_price' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    /** Productos cuyo stock llegó al mínimo configurado. */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('image/' . $this->image) : null;
    }
}
