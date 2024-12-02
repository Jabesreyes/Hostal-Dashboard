<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@hostal.com',
            'password' => Hash::make('admin123'), 
        ]);

        // Crear un usuario de ejemplo
        User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'cliente@hostal.com',
            'password' => Hash::make('cliente123'), 
        ]);
    }
}
