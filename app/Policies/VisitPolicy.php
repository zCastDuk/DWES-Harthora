<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\Sale;
use App\Models\User;
use App\Models\Visit;

class VisitPolicy
{
    public function create(User $user, Property $property): bool
    {
        if ($property->status !== 'available') {
            return false;
        }

        if ($user->roles() === 'client') {
            return $user->can('view', $property);
        }

        if ($user->roles() === 'commercial') {
            return $user->agent->id === $property->agent_id;
        }

        return false;
    }

   public function view(User $user, Visit $visit): bool
   {
       if($user->roles() === 'client') {
           return $user->client->id === $visit->client_id;
       }
       if($user->roles() === 'commercial') {
           return $user->client->id === $visit->client_id;
       }
       if($user->roles() === 'management') {
            return true;
       }
       return false;
   }

   public function update(User $user, Visit $visit): bool
   {
       return in_array($visit->status, ['pending', 'confirmed'])
           && ($user->client?->id === $visit->client_id
               || $user->agent?->id === $visit->agent_id);
   }

    public function confirm(User $user, Visit $visit): bool
    {
        return $user->agent?->id === $visit->agent_id
            && $visit->status === 'pending';
    }

    public function cancel(User $user, Visit $visit): bool
    {
        return $this->update($user, $visit);

    }
}
