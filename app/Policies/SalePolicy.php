<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    public function create(User $user, Property $property)
    {
        //¿La casa esta disponible?
        if($property->status !== 'available'){
            return false;
        }

        //¿Es cliente? ¿Puede ver esa casa?
        if ($user->roles() === 'client') {
            return $user->can('view', $property);
        }

        //¿Es agente? ¿Es su casa?
        if ($user->roles() === 'commercial') {
            return $user->agent->id === $property->agent_id;
        }

        return false;
    }

    public function view(User $user, Sale $sale): bool
    {
        if ($user->roles() === 'financial' || $user->roles() === 'management') {
            return true;
        }

        // El comercial ve las ventas que lleva él
        if ($user->roles() === 'commercial') {
            return $user->agent->id === $sale->agent_id;
        }

        // El cliente ve solo las ventas en las que es el comprador
        if ($user->roles() === 'client') {
            return $user->client->id === $sale->client_id;
        }

        return false;
    }
    public function validate(User $user, Sale $sale): bool
    {
        return $user->roles() === 'financial'
            && $sale->status === 'pending';
    }
    public function reject(User $user, Sale $sale): bool
    {
        return $this->validate($user, $sale);
    }

    public function updatePrice(User $user, Sale $sale): bool
    {
        return $user->roles() === 'commercial' && //Si es comercial
               $user->agent->id === $sale->agent_id && //si es su venta
               $sale->status == 'pending'; //si la venta sigue pendiente
    }
    public function viewBuyerData(User $user, Sale $sale): bool
    {
        return in_array($user->roles(), ['financial', 'management']);
    }
}
