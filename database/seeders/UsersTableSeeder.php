<?php
namespace Database\Seeders;

use Fxneiram\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'special' => 'all-access',
        ]);
        
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin Admin',
            'email' => 'admin@black.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
