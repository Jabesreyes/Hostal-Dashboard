<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paises = [
            ['siglas' => 'USA', 'nombre' => 'Estados Unidos'],
            ['siglas' => 'CAN', 'nombre' => 'Canadá'],
            ['siglas' => 'MEX', 'nombre' => 'México'],
            ['siglas' => 'ARG', 'nombre' => 'Argentina'],
            ['siglas' => 'BRA', 'nombre' => 'Brasil'],
            ['siglas' => 'CHL', 'nombre' => 'Chile'],
            ['siglas' => 'COL', 'nombre' => 'Colombia'],
            ['siglas' => 'ESP', 'nombre' => 'España'],
            ['siglas' => 'DEU', 'nombre' => 'Alemania'],
            ['siglas' => 'FRA', 'nombre' => 'Francia'],
            ['siglas' => 'ITA', 'nombre' => 'Italia'],
            ['siglas' => 'JPN', 'nombre' => 'Japón'],
            ['siglas' => 'CHN', 'nombre' => 'China'],
            ['siglas' => 'IND', 'nombre' => 'India'],
            ['siglas' => 'RUS', 'nombre' => 'Rusia'],
            ['siglas' => 'ZAF', 'nombre' => 'Sudáfrica'],
            ['siglas' => 'AUS', 'nombre' => 'Australia'],
            ['siglas' => 'GBR', 'nombre' => 'Reino Unido'],
            ['siglas' => 'KOR', 'nombre' => 'Corea del Sur'],
        ];

        DB::table('pais')->insert($paises);
    }
}
