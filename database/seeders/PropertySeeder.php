<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Feature;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Zone;
use Illuminate\Database\Seeder;

/* Casas + sus dos tablas pivote:
 *   feature_property -> qué features tiene cada casa
 *   favorites        -> qué casas ha guardado cada cliente
 * Necesita que antes existan zonas, features, propietarios, agentes y clientes.
 * */
class PropertySeeder extends Seeder
{
    // Rango de sobrecoste (en euros) según el nivel de la feature
    private const SURCHARGE_RANGES = [
        'low'    => [1000, 9000],     // experiencial: menos de 10.000 €
        'medium' => [10000, 20000],   // ubicación o acceso
        'high'   => [20000, 25000],   // construcción
    ];

    public function run(): void
    {
        // ---- 1. Casas ----
        // recycle(): en vez de crear zonas, propietarios y agentes nuevos,
        // la factory elige al azar entre los que ya existen.
        // Solo se pasan los comerciales, porque son los únicos que llevan casas.
        $properties = Property::factory()
            ->count(40)
            ->recycle(Zone::all())
            ->recycle(Owner::all())
            ->recycle(Agent::where('role', 'commercial')->get())
            ->create();

        // ---- 2. Features de cada casa (pivote feature_property) ----
        $features = Feature::all();

        foreach ($properties as $property) {
            // ~1 de cada 5 casas es "estándar": sin features
            if (fake()->boolean(20)) {
                continue; // salta a la siguiente casa
            }

            // Entre 1 y 5 features distintas (random con número nunca repite)
            foreach ($features->random(rand(1, 5)) as $feature) {
                [$min, $max] = self::SURCHARGE_RANGES[$feature->surcharge_tier];

                // attach(id, [columnas extra de la pivote])
                $property->features()->attach($feature->id, [
                    'detail' => fake()->optional(0.5)->randomElement([
                        'Reformado recientemente',
                        'En perfecto estado',
                        'De uso privado',
                        'Con mantenimiento incluido',
                    ]),
                    'estimated_value' => fake()->numberBetween($min / 1000, $max / 1000) * 1000,
                ]);
            }
        }

        // ---- 3. Favoritos de cada cliente (pivote favorites) ----
        foreach (Client::all() as $client) {
            // Solo puede guardar casas que puede ver:
            // publicadas, y si es exclusiva, solo si el cliente es premium
            $visible = $properties->filter(fn ($p) =>
                $p->published_at !== null && (! $p->is_exclusive || $client->is_premium)
            );

            $howMany = min(rand(0, 5), $visible->count());

            foreach ($visible->random($howMany) as $property) {
                $client->favorites()->attach($property->id, [
                    'note' => fake()->optional(0.4)->randomElement([
                        'Me encanta la terraza',
                        'Preguntar por la financiación',
                        'Visitar con mi pareja',
                        'Comparar con la de la costa',
                        'Buena zona para los niños',
                    ]),
                    'price_drop_alert' => fake()->boolean(30),
                ]);
            }
        }
    }
}
