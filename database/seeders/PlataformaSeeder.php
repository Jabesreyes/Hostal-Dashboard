<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlataformaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plataformas = [
            ['plataforma' => 'Booking'],
            ['plataforma' => 'WhatsApp'],
            ['plataforma' => 'Airbnb'],
            ['plataforma' => 'Facebook'],
        ];

        DB::table('plataformas')->insert($plataformas);
    }
}
