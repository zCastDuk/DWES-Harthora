<?php

use App\Models\Client;
use App\Models\Property;
use App\Models\User;
use App\Models\Zone;

/* Pruebas iniciales de relaciones: un ejemplo de cada tipo.
 * Usan una base de datos en memoria que se vacía en cada test (RefreshDatabase,
 * configurado en tests/Pest.php), así que no tocan los datos de database.sqlite.
 * */

// ---- 1:1 -> users <-> clients ----
test('un usuario tiene su perfil de cliente y el cliente conoce a su usuario', function () {
    $client = Client::factory()->create();
    $user   = $client->user;

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->type)->toBe('client')
        ->and($user->client->id)->toBe($client->id);
});

// ---- 1:N -> zones -> properties ----
test('una zona tiene varias casas y cada casa conoce su zona', function () {
    $zone = Zone::factory()->create();

    // for(): las 3 casas pertenecen a esta zona
    Property::factory()->count(3)->for($zone)->create();

    expect($zone->properties)->toHaveCount(3)
        ->and($zone->properties->first()->zone->id)->toBe($zone->id);
});

// ---- N:N con columnas extra en la pivote -> clients <-> properties (favorites) ----
test('un cliente guarda casas en favoritos con nota y puede cambiar la alerta de precio', function () {
    $client = Client::factory()->create();

    // recycle(): las dos casas comparten zona (la tabla zones no admite zonas repetidas)
    $zone = Zone::factory()->create();
    [$villa, $atico] = Property::factory()->count(2)->recycle($zone)->create();

    // Crear: attach(id, [columnas extra de la pivote])
    $client->favorites()->attach($villa->id, [
        'note'             => 'Preguntar por la financiación',
        'price_drop_alert' => false,
    ]);
    $client->favorites()->attach($atico->id);

    // Leer: las columnas extra se leen desde ->pivot
    $favorite = $client->favorites()->find($villa->id);

    expect($client->favorites)->toHaveCount(2)
        ->and($favorite->pivot->note)->toBe('Preguntar por la financiación')
        ->and((bool) $favorite->pivot->price_drop_alert)->toBeFalse()
        ->and($villa->favoritedBy->first()->id)->toBe($client->id); // y al revés

    // Actualizar: cambiar una columna extra de un favorito que ya existe
    $client->favorites()->updateExistingPivot($villa->id, ['price_drop_alert' => true]);

    expect((bool) $client->favorites()->find($villa->id)->pivot->price_drop_alert)->toBeTrue();
});
