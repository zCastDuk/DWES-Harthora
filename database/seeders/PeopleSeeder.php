<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Owner;
use Illuminate\Database\Seeder;

/* Datos FALSOS de personas: propietarios, clientes y agentes.
 * Las cantidades completan a los usuarios fijos de TestUserSeeder:
 *   clientes: 18 aquí + 2 fijos = 20 (5 premium en total)
 *   agentes:   5 aquí + 3 fijos = 8  (5 comerciales, 2 financieros, 1 directivo)
 * */
class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        // Propietarios: no tienen cuenta en la web, solo datos de contacto
        Owner::factory()->count(15)->create();

        // Clientes: 4 premium + 14 normales (cada uno crea su propio usuario)
        Client::factory()->premium()->count(4)->create();
        Client::factory()->count(14)->create(['is_premium' => false]);

        // Agentes comerciales: 2 seniors y 2 novatos (+ el comercial fijo, que es senior)
        Agent::factory()->senior()->count(2)->create();
        Agent::factory()->novice()->count(2)->create();

        // Agente financiero (+ el financiero fijo)
        Agent::factory()->financial()->create();

        // El directivo es solo el fijo de TestUserSeeder
    }
}
