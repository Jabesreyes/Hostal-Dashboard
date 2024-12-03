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
            ['estado' => 'reservado', 'color' => '#FFEBCD'], // Verde
            ['estado' => 'ingresado', 'color' => '#4CAF50'], // Verde
            ['estado' => 'retirado', 'color' => '#F44336'],  // Amarillo
        ];

        DB::table('estado_reservas')->insert($estados);
    }
}
