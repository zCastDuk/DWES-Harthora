<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;
class FeatureSeeder extends Seeder
{

    public function run(): void
    {
        $features = require database_path('data/features.php');

        // Una feature por cada fila de la lista, en orden y sin repetir
        Feature::factory()
            ->count(count($features))
            ->sequence(...$features)
            ->create();
    }
}
