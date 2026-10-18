<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'surcharge_tier'])]
class Feature extends Model{
    use HasFactory;

    public function properties(): BelongsToMany{
        return $this->belongsToMany(Property::class)
            ->withPivot('detail', 'estimated_value')
            ->withTimestamps();
    }
}
