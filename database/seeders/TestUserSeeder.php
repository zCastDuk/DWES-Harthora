<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

/* Usuarios FIJOS para poder iniciar sesión mientras se desarrolla.
 * Uno por cada rol. Todos con la contraseña "harthora" (la pone la UserFactory).
 * Solo para desarrollo: en producción no deben existir.
 * */
class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Clientes ----

        Client::factory()
            ->for(User::factory()->client()->state(['email' => 'cliente@harthora.test']))
            ->create(['is_premium' => false]);

        Client::factory()
            ->premium()
            ->for(User::factory()->client()->state(['email' => 'premium@harthora.test']))
            ->create();

        // ---- Agentes ----

        Agent::factory()
            ->senior()
            ->for(User::factory()->agent()->state(['email' => 'comercial@harthora.test']))
            ->create();

        Agent::factory()
            ->financial()
            ->for(User::factory()->agent()->state(['email' => 'financiero@harthora.test']))
            ->create();

        Agent::factory()
            ->management()
            ->for(User::factory()->agent()->state(['email' => 'directivo@harthora.test']))
            ->create();
    }
}
