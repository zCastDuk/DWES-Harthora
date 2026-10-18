<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'nif', 'tax_address', 'is_premium'])]
class Client extends Model{
    use HasFactory;

    //Comprobar si tiene acceso a "Catalogo Especial"
    protected function casts(): array{
        return [
            'is_premium' => 'boolean',
        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function favorites(): BelongsToMany{
        return $this->belongsToMany(Property::class, 'favorites') //renombre de tabla pivote
            ->withPivot('note', 'price_drop_alert')
            ->withTimestamps();
    }

    public function visits(): HasMany{
        return $this->hasMany(Visit::class);
    }

    public function sales(): HasMany{
        return $this->hasMany(Sale::class);
    }
}
