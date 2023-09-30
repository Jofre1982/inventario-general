<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public $table = 'businesses';

    protected $fillable = [
        'name',
        'descriptions',
        'logo',
        'mail',
        'address',
        'nit',
    ];
}
