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
            'company_name'          => fake()->company(),
            // cif es unique en la migración: unique() evita que Faker lo repita
            'cif'                   => fake()->unique()->vat(),
            'phone'                 => fake()->numerify('6########'),
            'address'               => fake()->address(),
            'email'                 => fake()->companyEmail(),
            'type'                  => fake()->randomElement(['developer', 'architecture_studio']),
            'logo'                  => null,
            'website'               => null,
            'description'           => null,
        ];
    }
}
