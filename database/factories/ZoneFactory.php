<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zone>
 */
class ZoneFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        $zona = fake()->randomElement(require database_path('data/zones.php'));

        return [
            /* Para hacer la indexación de datos más realista, se crea zones.php.
             * Fichero proporcionado por la IA para incluir zonas realistas de España
             * Al ser zonas reales, tenemos datos fieles y no "Malasaña, Murcia"
             * */
            'neighborhood' => $zona['neighborhood'],
            'city'         => $zona['city'],
            'province'     => $zona['province'],
            //Fijado por defecto, por valorar ampliación a otros paises
            'country' => 'España',
        ];
    }
}
