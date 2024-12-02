<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodos = [
            ['metodo' => 'Efectivo'],
            ['metodo' => 'Tarjeta'],
        ];

        DB::table('metodo_pagos')->insert($metodos);
    }
}
