<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Asistente de configuración inicial (lo usa INSTALAR.bat)
|--------------------------------------------------------------------------
| Pregunta el nombre del negocio y los datos del administrador.
| Presionar Enter deja el valor actual.
*/
Artisan::command('inventario:configurar', function () {
    $business = \App\Models\Business::current();
    $admin = \App\Models\User::whereHas('roles', fn ($q) => $q->where('special', 'all-access'))->orderBy('id')->first()
        ?? \App\Models\User::orderBy('id')->first();

    $this->info('');
    $this->info('  CONFIGURACIÓN DEL NEGOCIO (Enter = dejar como está)');
    $this->info('');

    $name = $this->ask('Nombre del negocio', $business->name);
    $nit = $this->ask('NIT (opcional)', $business->nit ?: '-');
    $address = $this->ask('Dirección y teléfono (opcional)', $business->address ?: '-');

    $business->update([
        'name' => trim($name),
        'nit' => $nit === '-' ? '' : trim($nit),
        'address' => $address === '-' ? '' : trim($address),
    ]);

    if (! $admin) {
        $this->warn('No hay usuario administrador; ejecute primero las migraciones con --seed.');
        return 1;
    }

    $this->info('');
    $this->info('  USUARIO ADMINISTRADOR');
    $this->info('');

    $email = $this->ask('Correo para ingresar', $admin->email);
    while (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = $this->ask('Ese correo no es válido. Correo para ingresar', $admin->email);
    }

    $password = null;
    if (\Illuminate\Support\Facades\Hash::check('secret', $admin->password) || $this->confirm('¿Cambiar la contraseña del administrador?', false)) {
        while (true) {
            $password = (string) $this->secret('Nueva contraseña (mínimo 6 caracteres, no se ve al escribir)');
            if (mb_strlen($password) < 6) {
                $this->error('Muy corta, use al menos 6 caracteres.');
                continue;
            }
            if ($this->secret('Repita la contraseña') !== $password) {
                $this->error('No coinciden, intente de nuevo.');
                continue;
            }
            break;
        }
    }

    $admin->email = trim($email);
    if ($password !== null) {
        $admin->password = \Illuminate\Support\Facades\Hash::make($password);
    }
    $admin->save();

    $this->info('');
    $this->info("  Listo. Ingrese con: {$admin->email}");
    return 0;
})->purpose('Configura el nombre del negocio y el usuario administrador');
