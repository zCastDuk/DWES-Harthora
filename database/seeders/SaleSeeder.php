<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Commission;
use App\Models\Property;
use App\Models\Sale;
use Illuminate\Database\Seeder;

/* Ventas y comisiones, cuadradas con el estado de cada casa:
 *   sold      -> venta validada + su comisión
 *   reserved  -> venta pendiente (falta que el financiero la valide)
 *   available -> normalmente sin venta; ~1 de cada 5 con una venta rechazada
 * */
class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $clients    = Client::all();
        // Solo los financieros validan o rechazan ventas
        $financials = Agent::where('role', 'financial')->get();

        foreach (Property::all() as $property) {
            // El comprador tiene que poder ver la casa: si es exclusiva, solo premium
            $buyer = $clients
                ->filter(fn ($c) => ! $property->is_exclusive || $c->is_premium)
                ->random();

            $data = [
                'property_id' => $property->id,
                'client_id'   => $buyer->id,
            ];

            if ($property->status === 'sold') {
                $sale = Sale::factory()->validated()->recycle($financials)->create($data);

                // Sin venta validada no hay comisión
                Commission::factory()->create(['sale_id' => $sale->id]);
            } elseif ($property->status === 'reserved') {
                Sale::factory()->pending()->create($data);
            } elseif (fake()->boolean(20)) {
                // Casa disponible con un intento de venta que no salió
                Sale::factory()->rejected()->recycle($financials)->create($data);
            }
        }
    }
}
