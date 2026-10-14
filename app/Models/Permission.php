<?php

namespace App\Models;

use Fxneiram\Shinobi\Models\Permission as ShinobiModel;

/**
 * Modelo de Shinobi con un arreglo: el paquete intenta limpiar una caché
 * con etiquetas (tags) cada vez que se guarda, y la caché por archivos o
 * base de datos no las soporta (lanzaba "This cache store does not
 * support tagging"). Aquí solo se limpia si la caché lo permite.
 */
class Permission extends ShinobiModel
{
    public static function bootRefreshesPermissionCache()
    {
        $flush = function () {
            if (cache()->getStore() instanceof \Illuminate\Cache\TaggableStore) {
                cache()->tags(config('shinobi.cache.tag'))->flush();
            }
        };

        static::saved($flush);
        static::deleted($flush);
    }
}
