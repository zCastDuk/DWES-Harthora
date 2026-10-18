<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory{
    public function definition(): array{
        return [
            // Relación 1:1: cada cliente crea su propio usuario (de tipo client),
            // así user_id nunca se repite
            'user_id'     => User::factory()->client(),
            'nif'         => fake()->unique()->dni(),
            'tax_address' => fake()->address(),
            // Aproximadamente 1 de cada 4 clientes es premium
            'is_premium'  => fake()->boolean(25),
        ];
    }

    // Cliente premium (acceso al catálogo exclusivo)
    public function premium(): static{
        return $this->state(fn (array $attributes) => [
            'is_premium' => true,
        ]);
    }
}
