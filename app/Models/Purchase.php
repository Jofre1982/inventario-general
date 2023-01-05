<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'provider_id',
        'user_id',
        'purchese_date',
        'tax',
        'total',
        'status',
        'picture',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function Client(){
        return $this->belongsTo(Client::class);
    }
    
    public function saleDetails(){
        return $this->hasMany(saleDetails::class);
    }
    
}
