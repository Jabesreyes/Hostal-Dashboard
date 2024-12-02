<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['estado' => 'completa', 'color' => '#FFEBCD'], // Verde
            ['estado' => 'Reserva confirmada', 'color' => '#4CAF50'], // Verde
            ['estado' => 'Reserva pendiente', 'color' => '#FFEB3B'],  // Amarillo
            ['estado' => 'Reserva cancelada', 'color' => '#F44336'],  // Rojo
        ];

        DB::table('estado_reservas')->insert($estados);
    }
}
