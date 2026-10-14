<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    public const CONNECTORS = [
        'windows' => 'Impresora compartida en Windows',
        'network' => 'Impresora de red (IP)',
        'cups' => 'Impresora en Linux / macOS (CUPS)',
    ];

    protected $fillable = [
        'name',
        'connector',
        'host',
        'port',
        'width',
    ];

    protected $casts = [
        'port' => 'integer',
        'width' => 'integer',
    ];

    /** Siempre hay un solo registro de impresora; se crea si no existe. */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'name' => 'TM20',
            'connector' => 'windows',
            'port' => 9100,
            'width' => 42,
        ]);
    }
}
