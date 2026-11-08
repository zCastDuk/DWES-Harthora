<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function view(?User $user, Property $property): bool
    {
        if ($property->published_at !== null && $property->published_at->isPast()) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        if ($user->roles() !== 'client') {
            return true;
        }

        return $property->is_exclusive && $user->client?->is_premium === true;
    }

    public function update(User $user, Property $property): bool
    {
        return $user->roles() === 'management';
    }

    public function create(User $user): bool
    {
        return $user->roles() === 'management';
    }
    public function delete(User $user, Property $property): bool
    {
        return $user->roles() === 'management'
            && ! $property->sales()->exists();
    }
    public function markFavorite(User $user, Property $property): bool
    {
        return $user->roles() === 'client' && $this->view($user, $property);
    }
}
