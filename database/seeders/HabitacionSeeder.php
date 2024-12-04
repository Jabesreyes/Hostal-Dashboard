<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $habitaciones = [
            [
                'numero' => 101,
                'nombre' => 'Habitación Simple',
                'capacidad' => 1,
                'descripcion' => 'Habitación cómoda para una persona, ideal para viajes de negocios.',
                'estados_id' => 1, // Disponible
                'precio' => 30.00,
                'precio_promocion' => null,
                'color' => '#ffcc00'
            ],
            [
                'numero' => 102,
                'nombre' => 'Habitación Doble',
                'capacidad' => 2,
                'descripcion' => 'Espaciosa habitación para dos personas con cama doble.',
                'estados_id' => 1, // Disponible
                'precio' => 50.00,
                'precio_promocion' => 45.00,
                'color' => '#00ccff'
            ],
            [
                'numero' => 103,
                'nombre' => 'Suite Familiar',
                'capacidad' => 3,
                'descripcion' => 'Habitación ideal para familias, incluye sala y cocina pequeña.',
                'estados_id' => 2, // Ocupada
                'precio' => 100.00,
                'precio_promocion' => null,
                'color' => '#66cc33'
            ],
            [
                'numero' => 104,
                'nombre' => 'Habitación Deluxe',
                'capacidad' => 2,
                'descripcion' => 'Habitación de lujo con vista al mar y jacuzzi.',
                'estados_id' => 3, // Limpieza
                'precio' => 150.00,
                'precio_promocion' => 120.00,
                'color' => '#ff6699'
            ],
            [
                'numero' => 105,
                'nombre' => 'Habitación Económica',
                'capacidad' => 1,
                'descripcion' => 'Opción económica para estadías cortas.',
                'estados_id' => 3, // Mantenimiento
                'precio' => 20.00,
                'precio_promocion' => 18.00,
                'color' => '#999999'
            ],
        ];

        DB::table('habitacions')->insert($habitaciones);
    }
}
