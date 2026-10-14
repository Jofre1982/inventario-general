<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public const VALID = 'VALID';
    public const CANCELED = 'CANCELED';

    protected $fillable = [
        'provider_id',
        'user_id',
        'purchase_date',
        'tax',
        'total',
        'status',
        'picture',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'tax' => 'float',
        'total' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function scopeValid($query)
    {
        return $query->where('status', self::VALID);
    }

    public function isValid(): bool
    {
        return $this->status === self::VALID;
    }

    public function getSubtotalAttribute(): float
    {
        return round($this->purchaseDetails->sum(fn ($d) => $d->quantity * $d->price), 2);
    }

    public function getTaxAmountAttribute(): float
    {
        return round($this->total - $this->subtotal, 2);
    }
}
