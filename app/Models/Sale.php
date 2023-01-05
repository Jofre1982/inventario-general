<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'sale_date',
        'tax',
        'total',
        'status',
      
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    
    public function purchaseDetails(){
        return $this->hasMany(PurchaseDetails::class);
    }
}
