<?php

/*
 * Catálogo de características de las casas.
 * surcharge_tier (sobrecoste):
 *   high   -> requiere construcción (piscina, bodega...)
 *   medium -> ubicación o acceso (cerca del centro, aeropuerto...)
 *   low    -> particularidad experiencial (vistas, luz, tranquilidad...)
 */
return [
    // Construcción -> sobrecoste alto
    ['name' => 'Piscina',                       'surcharge_tier' => 'high'],
    ['name' => 'Piscina climatizada',           'surcharge_tier' => 'high'],
    ['name' => 'Jardín',                        'surcharge_tier' => 'high'],
    ['name' => 'Bodega',                        'surcharge_tier' => 'high'],
    ['name' => 'Gimnasio privado',              'surcharge_tier' => 'high'],
    ['name' => 'Spa',                           'surcharge_tier' => 'high'],
    ['name' => 'Garaje',                        'surcharge_tier' => 'high'],
    ['name' => 'Ascensor privado',              'surcharge_tier' => 'high'],
    ['name' => 'Sala de cine',                  'surcharge_tier' => 'high'],
    ['name' => 'Pista de pádel',                'surcharge_tier' => 'high'],

    // Ubicación y acceso -> sobrecoste medio
    ['name' => 'Cerca del centro de la ciudad', 'surcharge_tier' => 'medium'],
    ['name' => 'Acceso rápido a la autopista',  'surcharge_tier' => 'medium'],
    ['name' => 'Cerca del aeropuerto',          'surcharge_tier' => 'medium'],
    ['name' => 'Cerca de colegios internacionales', 'surcharge_tier' => 'medium'],
    ['name' => 'Primera línea de playa',        'surcharge_tier' => 'medium'],
    ['name' => 'Transporte público cercano',    'surcharge_tier' => 'medium'],

    // Experiencial -> sobrecoste bajo
    ['name' => 'Vistas al mar',                 'surcharge_tier' => 'low'],
    ['name' => 'Vistas a la montaña',           'surcharge_tier' => 'low'],
    ['name' => 'Orientación sur',               'surcharge_tier' => 'low'],
    ['name' => 'Luz natural todo el día',       'surcharge_tier' => 'low'],
    ['name' => 'Entorno tranquilo',             'surcharge_tier' => 'low'],
    ['name' => 'Puestas de sol',                'surcharge_tier' => 'low'],
];
