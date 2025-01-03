<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PaisSeeder::class);
        $this->call(PlataformaSeeder::class);
        $this->call(EstadoReservaSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(HabitacionSeeder::class);
        $this->call(MetodoPagoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ReservaSeeder::class);



        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
