<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Property;
use App\Models\Visit;
use Illuminate\Database\Seeder;

/* Visitas a las casas.
 * La fecha, la franja, el comercial y el estado los pone la VisitFactory.
 * Aquí solo elegimos QUÉ casa y QUÉ cliente, para que tenga sentido.
 * */
class VisitSeeder extends Seeder
{
    public function run(): void
    {
        // Solo casas publicadas y no vendidas
        $properties = Property::whereNotNull('published_at')
            ->where('status', '!=', 'sold')
            ->get();

        $clients = Client::all();

        for ($i = 0; $i < 30; $i++) {
            $property = $properties->random();

            // El cliente tiene que poder ver la casa: si es exclusiva, solo premium
            $client = $clients
                ->filter(fn ($c) => ! $property->is_exclusive || $c->is_premium)
                ->random();

            Visit::factory()->create([
                'property_id' => $property->id,
                'client_id'   => $client->id,
            ]);
        }
    }
}
