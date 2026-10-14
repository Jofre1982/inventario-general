<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Protege las acciones de un recurso con los permisos de Shinobi
     * (ver database/seeders/PermissionsTableSeeder.php).
     *
     *   products.index   -> index
     *   products.show    -> show
     *   products.create  -> create, store
     *   products.edit    -> edit, update
     *   products.destroy -> destroy
     *
     * $extra permite agregar permisos propios: ['sales.pdf' => 'pdf'].
     */
    protected function protectWithPermissions(string $prefix, array $extra = []): void
    {
        $map = [
            'index' => ['index'],
            'show' => ['show'],
            'create' => ['create', 'store'],
            'edit' => ['edit', 'update'],
            'destroy' => ['destroy'],
        ];

        foreach ($map as $ability => $methods) {
            $this->middleware("can:{$prefix}.{$ability}")->only($methods);
        }

        foreach ($extra as $slug => $methods) {
            $this->middleware("can:{$slug}")->only((array) $methods);
        }
    }

    /**
     * Elimina un registro; si está siendo usado (ventas, compras, productos...)
     * la base de datos lo impide y se muestra un mensaje en vez de un error 500.
     */
    protected function deleteOrExplain(Model $model, string $route, string $inUseMessage)
    {
        try {
            $model->delete();
        } catch (QueryException $e) {
            return redirect()->route($route)->with('error', $inUseMessage);
        }

        return redirect()->route($route)->with('success', 'Registro eliminado.');
    }
}
