<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saleDetails extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',   
    ];
}
