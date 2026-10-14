<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'businesses';

    protected $fillable = [
        'name',
        'description',
        'logo',
        'mail',
        'address',
        'nit',
    ];

    /** Siempre hay un solo registro de empresa; se crea si no existe. */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'name' => config('app.name'),
            'description' => '',
            'logo' => '',
            'mail' => '',
            'address' => '',
            'nit' => '',
        ]);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('image/' . $this->logo) : null;
    }
}
