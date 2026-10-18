<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Property;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visit>
 */
class VisitFactory extends Factory{
    // Franjas de 1 hora: la primera empieza a las 9:00 y la última a las 19:00
    private const FIRST_HOUR = 9;
    private const LAST_HOUR  = 19;

    public function definition(): array{
        /* Cada visita recibe una fecha+franja DISTINTA a todas las demás (unique()).
         * Así nunca se incumplen los tres unique de la migración:
         *   casa + fecha + franja, agente + fecha + franja y cliente + fecha + franja
         * */
        $slot = Carbon::parse(fake()->unique()->randomElement(self::slots()));

        return [
            'client_id'   => Client::factory(),
            'property_id' => Property::factory(),
            // La visita la hace el comercial que lleva esa casa
            'agent_id'    => fn (array $attributes) => Property::find($attributes['property_id'])->agent_id,
            'date'        => $slot->toDateString(),   // 2026-10-20
            'time_slot'   => $slot->format('H:i:s'),  // 10:00:00
            // Pasada = realizada; futura = pendiente o confirmada
            'status'      => $slot->isPast()
                ? 'completed'
                : fake()->randomElement(['pending', 'confirmed']),
        ];
    }

    /* Lista de todas las franjas posibles: de lunes a viernes, de 9:00 a 19:00,
     * desde 3 meses atrás hasta 2 meses adelante.
     * static $slots hace que la lista se calcule una sola vez, no en cada visita.
     * */
    private static function slots(): array{
        static $slots = null;

        if ($slots === null) {
            $slots = [];
            $day   = now()->subMonths(3)->startOfDay();
            $end   = now()->addMonths(2);

            while ($day->lte($end)) {
                if ($day->isWeekday()) { // solo lunes a viernes
                    for ($hour = self::FIRST_HOUR; $hour <= self::LAST_HOUR; $hour++) {
                        $slots[] = $day->copy()->setTime($hour, 0)->format('Y-m-d H:i:s');
                    }
                }
                // Las fechas son inmutables (AppServiceProvider): addDay() no cambia $day,
                // devuelve una fecha nueva, así que hay que guardarla
                $day = $day->addDay();
            }
        }

        return $slots;
    }
}
