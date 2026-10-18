<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;
use illuminate\Support\Arr;

class ZoneSeeder extends Seeder
{
    /**
     * Se extraen los datos de database/data/zone.php, con zonas realistas
     * y fijas
     */
    public function run(): void{
        //Quitamos cp porque no existe en la tabla zones, sino en Property
        $zones = array_map(
            fn ($zone) => Arr::except($zone, 'postal_code'),
            require database_path('data/zones.php')
        );
        Zone::factory()
            ->count(count($zones))
            ->sequence(...$zones)
            ->create();
    }
}
