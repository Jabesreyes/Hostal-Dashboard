<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservas = [];
        $clientes = [1, 2, 3]; // IDs de clientes de ejemplo
        $habitaciones = [1, 2, 3]; // IDs de habitaciones de ejemplo
        $plataformas = [1, 2, 3]; // IDs de plataformas de ejemplo
        $metodos_pago = [1, 2]; // IDs de métodos de pago de ejemplo
        $estado_reservas = [1, 2, 3]; // IDs de estados de reservas de ejemplo

        for ($i = 1; $i <= 20; $i++) {
            $fecha_ingreso = Carbon::create(2024, rand(1, 12), rand(1, 28));
            $fecha_retiro = (clone $fecha_ingreso)->addDays(rand(1, 7));
            $completa = $fecha_retiro->isBefore(Carbon::now());

            $reservas[] = [
                'clientes_id' => $clientes[array_rand($clientes)],
                'habitacions_id' => $habitaciones[array_rand($habitaciones)],
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_retiro' => $fecha_retiro,
                'plataformas_id' => $plataformas[array_rand($plataformas)],
                'metodo_pagos_id' => $metodos_pago[array_rand($metodos_pago)],
                'fecha_reserva' => Carbon::now(),
                'total_pagado' => rand(100, 500),
                'precio_dia' => rand(50, 150),
                'estado_reservas_id' => $estado_reservas[array_rand($estado_reservas)],
                'congelar' => false,
                'completa' => $completa,
            ];
        }

        // Insertar las reservas
        DB::table('reservas')->insert($reservas);
    }
}
