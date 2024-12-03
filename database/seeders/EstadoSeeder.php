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
            ['estado' => 'disponible'],
            ['estado' => 'ocupada'],
            ['estado' => 'mantenimiento o limpieza'],
        ];

        DB::table('estados')->insert($estados);
        //coment
    }
}
