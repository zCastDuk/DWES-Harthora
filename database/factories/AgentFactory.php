<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agent>
 */
class AgentFactory extends Factory{
    public function definition(): array{
        return [
            // Relación 1:1: cada agente crea su propio usuario (de tipo agent)
            'user_id'   => User::factory()->agent(),
            // Repetimos 'commercial' para que salgan más comerciales que el resto
            'role'      => fake()->randomElement(['commercial', 'commercial', 'commercial', 'financial', 'management']),
            'hire_date' => fake()->dateTimeBetween('-20 years', '-1 month'),
        ];
    }

    // ---- Estados por puesto ----

    public function commercial(): static{
        return $this->state(fn (array $attributes) => ['role' => 'commercial']);
    }

    public function financial(): static{
        return $this->state(fn (array $attributes) => ['role' => 'financial']);
    }

    public function management(): static{
        return $this->state(fn (array $attributes) => ['role' => 'management']);
    }

    // ---- Estados por antigüedad (senior a partir de 5 años) ----

    // Comercial con menos de 5 años en la empresa
    public function novice(): static{
        return $this->state(fn (array $attributes) => [
            'role'      => 'commercial',
            'hire_date' => fake()->dateTimeBetween('-5 years +1 day', '-1 month'),
        ]);
    }

    // Comercial con 5 años o más en la empresa
    public function senior(): static{
        return $this->state(fn (array $attributes) => [
            'role'      => 'commercial',
            'hire_date' => fake()->dateTimeBetween('-20 years', '-5 years'),
        ]);
    }
}
