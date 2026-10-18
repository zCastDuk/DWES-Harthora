<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commission>
 */
class CommissionFactory extends Factory{
    public function definition(): array{
        return [
            // Solo hay comisión si la venta está validada
            'sale_id'    => Sale::factory()->validated(),
            // Las reglas viven en el modelo Agent; aquí solo las usamos
            'percentage' => fn (array $attributes) => self::percentageFor(Sale::find($attributes['sale_id'])),
            // Importe = precio de la venta x porcentaje
            'amount'     => function (array $attributes) {
                $sale = Sale::find($attributes['sale_id']);
                return round($sale->price * self::percentageFor($sale) / 100, 2);
            },
        ];
    }

    // Porcentaje del comercial de la venta, según su antigüedad el día de la venta
    private static function percentageFor(Sale $sale): float{
        return $sale->agent->commissionPercentageAt($sale->resolved_at);
    }
}
