<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Usuario administrador inicial. Cambie la contraseña al entrar
     * (menú Principal > Perfil).
     */
    public function run()
    {
        $admin = User::firstOrCreate(['email' => 'admin@black.com'], [
            'name' => 'Admin Admin',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
        ]);

        $role = Role::where('slug', 'admin')->first();
        if ($role) {
            $admin->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
