<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Crea o actualiza todos los permisos del sistema. Se puede ejecutar
 * varias veces sin duplicar nada:
 *
 *   php artisan db:seed --class=PermissionsTableSeeder
 */
class PermissionsTableSeeder extends Seeder
{
    /** Permisos con slug equivocado en versiones anteriores. */
    private const OBSOLETE = ['calients.edit', 'report.day', 'report.date'];

    public function run()
    {
        $crud = [
            'users' => ['usuarios', 'usuario'],
            'roles' => ['roles', 'rol'],
            'categories' => ['categorías', 'categoría'],
            'clients' => ['clientes', 'cliente'],
            'products' => ['productos', 'producto'],
            'providers' => ['proveedores', 'proveedor'],
        ];

        foreach ($crud as $prefix => [$plural, $singular]) {
            $this->permission("{$prefix}.index", "Navegar {$plural}", "Lista y busca {$plural}");
            $this->permission("{$prefix}.show", "Ver detalle de {$singular}", "Ver el detalle de cada {$singular}");
            $this->permission("{$prefix}.create", "Crear {$plural}", "Registrar {$plural} nuevos");
            $this->permission("{$prefix}.edit", "Editar {$plural}", "Modificar los datos de {$plural}");
            $this->permission("{$prefix}.destroy", "Eliminar {$plural}", "Eliminar {$plural}");
        }

        foreach (['purchases' => ['compras', 'compra'], 'sales' => ['ventas', 'venta']] as $prefix => [$plural, $singular]) {
            $this->permission("{$prefix}.index", "Navegar {$plural}", "Lista y busca {$plural}");
            $this->permission("{$prefix}.show", "Ver detalle de {$singular}", "Ver el detalle de cada {$singular}");
            $this->permission("{$prefix}.create", "Registrar {$plural}", "Registrar {$plural} nuevas (mueve el stock)");
            $this->permission("{$prefix}.pdf", "Descargar PDF de {$singular}", "Descargar el comprobante en PDF");
        }

        $this->permission('sales.print', 'Imprimir ticket de venta', 'Enviar el ticket a la impresora térmica');
        $this->permission('upload.purchases', 'Adjuntar factura de compra', 'Subir la foto o PDF de la factura del proveedor');

        $this->permission('change.status.products', 'Activar / desactivar productos', 'Un producto inactivo no aparece para vender');
        $this->permission('change.status.purchases', 'Anular compras', 'Anular o reactivar compras (ajusta el stock)');
        $this->permission('change.status.sales', 'Anular ventas', 'Anular o reactivar ventas (devuelve el stock)');

        $this->permission('business.index', 'Ver datos de la empresa', 'Ver nombre, NIT, logo...');
        $this->permission('business.edit', 'Editar datos de la empresa', 'Modificar los datos de la empresa');
        $this->permission('printer.index', 'Ver impresora', 'Ver la configuración de la impresora de tickets');
        $this->permission('printer.edit', 'Configurar impresora', 'Modificar y probar la impresora de tickets');

        $this->permission('reports.day', 'Reporte del día', 'Ver las ventas del día');
        $this->permission('reports.date', 'Reporte por fechas', 'Ver las ventas en un rango de fechas');

        Permission::whereIn('slug', self::OBSOLETE)->get()->each(function (Permission $permission) {
            $permission->roles()->detach();
            $permission->delete();
        });

        $this->defaultRoles();
    }

    private function permission(string $slug, string $name, string $description): void
    {
        Permission::updateOrCreate(['slug' => $slug], compact('name', 'description'));
    }

    private function defaultRoles(): void
    {
        Role::firstOrCreate(['slug' => 'admin'], [
            'name' => 'Admin',
            'description' => 'Acceso total al sistema',
            'special' => 'all-access',
        ]);

        $cashier = Role::firstOrCreate(['slug' => 'cajero'], [
            'name' => 'Cajero',
            'description' => 'Registra ventas, imprime tickets y consulta productos y clientes',
        ]);

        if ($cashier->wasRecentlyCreated) {
            $cashier->permissions()->sync(Permission::whereIn('slug', [
                'sales.index', 'sales.show', 'sales.create', 'sales.pdf', 'sales.print',
                'clients.index', 'clients.show', 'clients.create',
                'products.index', 'products.show',
                'reports.day',
            ])->pluck('id'));
        }
    }
}
