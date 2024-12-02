<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos clientes de ejemplo
        $clientes = [
            [
                'nombre' => 'Juan Pérez',
                'telefono' => '1234567890',
                'correo' => 'juan.perez@example.com',
                'registro' => Carbon::now(),
                'pais_id' => 1, 
            ],
            [
                'nombre' => 'Ana Gómez',
                'telefono' => '0987654321',
                'correo' => 'ana.gomez@example.com',
                'registro' => Carbon::now(),
                'pais_id' => 2, 
            ],
            [
                'nombre' => 'Carlos Fernández',
                'telefono' => '1122334455',
                'correo' => 'carlos.fernandez@example.com',
                'registro' => Carbon::now(),
                'pais_id' => 3, 
            ],
        ];

        // Insertar los clientes
        DB::table('clientes')->insert($clientes);
    }
}
