<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Property;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory{
    public function definition(): array{
        // Primero decidimos el estado, porque de él dependen otros campos
        $status = fake()->randomElement(['pending', 'validated', 'validated', 'rejected']);

        return [
            'property_id'    => Property::factory(),
            'client_id'      => Client::factory(),
            // Vende el comercial que lleva esa casa
            'agent_id'       => fn (array $attributes) => Property::find($attributes['property_id'])->agent_id,
            // Se vende al precio de la casa (copiado en la venta)
            'price'          => fn (array $attributes) => Property::find($attributes['property_id'])->price,
            'payment_method' => fake()->randomElement(['transfer', 'mortgage', 'cash']),
            'status'         => $status,

            // Solo un financiero valida o rechaza; si está pendiente, nadie la ha resuelto aún
            'validated_by'     => $status === 'pending' ? null : Agent::factory()->financial(),
            'rejection_reason' => $status === 'rejected' ? self::rejectionReason() : null,
            'resolved_at'      => $status === 'pending' ? null : fn (array $attributes) => self::resolvedAt($attributes),
        ];
    }

    // ---- Estados ----

    public function pending(): static{
        return $this->state(fn (array $attributes) => [
            'status'           => 'pending',
            'validated_by'     => null,
            'rejection_reason' => null,
            'resolved_at'      => null,
        ]);
    }

    public function validated(): static{
        return $this->state(fn (array $attributes) => [
            'status'           => 'validated',
            'validated_by'     => Agent::factory()->financial(),
            'rejection_reason' => null,
            'resolved_at'      => fn (array $attributes) => self::resolvedAt($attributes),
        ]);
    }

    public function rejected(): static{
        return $this->state(fn (array $attributes) => [
            'status'           => 'rejected',
            'validated_by'     => Agent::factory()->financial(),
            'rejection_reason' => self::rejectionReason(),
            'resolved_at'      => fn (array $attributes) => self::resolvedAt($attributes),
        ]);
    }

    /* Fecha de resolución entre la contratación del comercial y hoy
     * (como mucho, 2 años atrás). Así nunca vende antes de trabajar aquí.
     * */
    private static function resolvedAt(array $attributes): \DateTime{
        $hireDate = Property::find($attributes['property_id'])->agent->hire_date;
        $from     = $hireDate->greaterThan(now()->subYears(2)) ? $hireDate : now()->subYears(2);

        return fake()->dateTimeBetween($from->toDateTime(), 'now'); // Faker solo acepta DateTime o texto
    }

    private static function rejectionReason(): string{
        return fake()->randomElement([
            'Financiación hipotecaria denegada.',
            'Documentación del comprador incompleta.',
            'El propietario ha retirado la oferta.',
            'No se ha podido acreditar el origen de los fondos.',
        ]);
    }
}
