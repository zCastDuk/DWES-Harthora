<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            // 9 cifras empezando por 6 (móvil español). numerify cambia cada # por un número
            'phone' => fake()->numerify('6########'),
            // Por defecto cliente; ClientFactory y AgentFactory usan los estados de abajo
            'type' => 'client',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('harthora'),
            'remember_token' => Str::random(10),
        ];
    }

    // Usuario que será el perfil de un cliente
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'client',
        ]);
    }

    // Usuario que será el perfil de un agente
    public function agent(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'agent',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
