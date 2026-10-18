<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory{
    public function definition(): array{
        /* Igual que las zonas, las features salen de un catálogo fijo (data/features.php).
         * unique(): name es unique en la migración, así Faker no repite la misma feature.
         * */
        $feature = fake()->unique()->randomElement(require database_path('data/features.php'));

        return [
            'name'           => $feature['name'],
            'surcharge_tier' => $feature['surcharge_tier'],
        ];
    }
}
