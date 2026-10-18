<?php

namespace Database\Factories;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Owner>
 */
class OwnerFactory extends Factory{
    public function definition(): array{
        return [
            'name'      => fake()->firstName(),
            'last_name' => fake()->lastName(),
            // nif es unique en la migración: unique() evita que Faker lo repita
            'nif'       => fake()->unique()->dni(),
            'phone'     => fake()->numerify('6########'),
            'email'     => fake()->safeEmail(),
        ];
    }
}
