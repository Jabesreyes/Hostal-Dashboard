<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['estado' => 'Disponible'],
            ['estado' => 'Ocupada'],
            ['estado' => 'Limpieza'],
            ['estado' => 'Mantenimiento'],
        ];

        DB::table('estados')->insert($estados);
        //coment
    }
}
