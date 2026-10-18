<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void{
        $this->call([
            // Catálogos (datos fijos sacados de database/data)
            ZoneSeeder::class,
            FeatureSeeder::class,

            // Personas
            TestUserSeeder::class,   // usuarios fijos para iniciar sesión
            PeopleSeeder::class,     // propietarios, clientes y agentes inventados

            // Casas (con sus features y los favoritos de los clientes)
            PropertySeeder::class,

            // Actividad sobre las casas
            VisitSeeder::class,
            SaleSeeder::class,       // ventas + comisiones
        ]);


    }
}
