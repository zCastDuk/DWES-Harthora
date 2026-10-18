<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory{
    // Traducción de los tipos (en inglés en la BD) para los textos en español
    private const TYPE_LABELS = [
        'villa'         => 'Villa',
        'chalet'        => 'Chalet',
        'penthouse'     => 'Ático',
        'flat'          => 'Piso',
        'country_house' => 'Casa de campo',
    ];

    public function definition(): array{
        $type      = fake()->randomElement(array_keys(self::TYPE_LABELS));
        $bedrooms  = fake()->numberBetween(2, 8);
        $builtArea = fake()->numberBetween(120, 1200);
        $entryDate = fake()->dateTimeBetween('-3 years', 'now');

        return [
            'owner_id' => Owner::factory(),
            // Solo los comerciales llevan casas (el financiero solo gestiona ventas)
            'agent_id' => Agent::factory()->commercial(),
            'zone_id'  => Zone::factory(),

            // Las funciones (fn) se ejecutan DESPUÉS de saber qué zona le ha tocado,
            // por eso pueden usar $attributes['zone_id'] para leer la zona
            'title' => fn (array $attributes) =>
                self::TYPE_LABELS[$type] . ' ' . fake()->randomElement(['exclusivo', 'de diseño', 'reformado', 'con encanto', 'de lujo'])
                . ' en ' . Zone::find($attributes['zone_id'])->neighborhood,

            'description' => $this->description(),
            'type'        => $type,
            'price'       => fake()->numberBetween(80, 900) * 10000, // de 800.000 € a 9.000.000 €, en múltiplos de 10.000
            'bedrooms'    => $bedrooms,
            'bathrooms'   => fake()->numberBetween(1, $bedrooms + 1),
            'built_area'  => $builtArea,
            'usable_area' => round($builtArea * fake()->randomFloat(2, 0.75, 0.9), 2), // la útil siempre es menor que la construida
            'address'     => fake()->streetAddress(),

            // Código postal real de la zona, sacado de data/zones.php
            'postal_code' => fn (array $attributes) => $this->postalCodeFor(Zone::find($attributes['zone_id'])),

            // Mayoría disponibles; las vendidas deberían tener su venta (lo cuadra el seeder)
            'status'       => fake()->randomElement(['available', 'available', 'available', 'reserved', 'sold']),
            'is_exclusive' => fake()->boolean(20), // ~1 de cada 5, solo para premium
            'portfolio_entry_date' => $entryDate,
            // Se publica después de entrar en cartera; ~10 % sin publicar todavía
            'published_at' => fake()->boolean(90) ? fake()->dateTimeBetween($entryDate, 'now') : null,
        ];
    }

    // ---- Estados ----

    public function available(): static{
        return $this->state(fn (array $attributes) => ['status' => 'available']);
    }

    public function sold(): static{
        return $this->state(fn (array $attributes) => ['status' => 'sold']);
    }

    // Solo visible para clientes premium
    public function exclusive(): static{
        return $this->state(fn (array $attributes) => ['is_exclusive' => true]);
    }

    // ---- Ayudantes ----

    // Busca en data/zones.php la fila de esta zona y devuelve su código postal
    private function postalCodeFor(Zone $zone): string{
        $row = collect(require database_path('data/zones.php'))
            ->first(fn ($z) => $z['neighborhood'] === $zone->neighborhood && $z['city'] === $zone->city);

        return $row['postal_code'] ?? fake()->postcode(); // por si la zona no está en la lista
    }

    // Descripción en español montada con frases al azar
    private function description(): string{
        return implode(' ', [
            fake()->randomElement([
                'Vivienda única en una de las zonas más exclusivas.',
                'Propiedad excepcional con acabados de alta calidad.',
                'Una oportunidad singular para vivir con total privacidad.',
                'Residencia de diseño contemporáneo y espacios amplios.',
            ]),
            fake()->randomElement([
                'Grandes ventanales que inundan de luz cada estancia.',
                'Cocina totalmente equipada con electrodomésticos de gama alta.',
                'Suite principal con vestidor y baño en suite.',
                'Salón de doble altura con chimenea.',
            ]),
            fake()->randomElement([
                'Ideal para familias que buscan tranquilidad.',
                'Perfecta como residencia principal o segunda vivienda.',
                'Lista para entrar a vivir.',
                'Visitas solo con cita previa.',
            ]),
        ]);
    }
}
