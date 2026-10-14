<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public const VALID = 'VALID';
    public const CANCELED = 'CANCELED';

    protected $fillable = [
        'client_id',
        'user_id',
        'sale_date',
        'tax',
        'total',
        'status',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'tax' => 'float',
        'total' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function scopeValid($query)
    {
        return $query->where('status', self::VALID);
    }

    public function isValid(): bool
    {
        return $this->status === self::VALID;
    }

    /** Suma de las líneas (con descuento) antes de impuesto. */
    public function getSubtotalAttribute(): float
    {
        return round($this->saleDetails->sum(fn ($d) => $d->subtotal), 2);
    }

    public function getTaxAmountAttribute(): float
    {
        return round($this->total - $this->subtotal, 2);
    }
}
