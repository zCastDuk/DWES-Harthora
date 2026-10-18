<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\CarbonInterface;

#[Fillable(['user_id', 'role', 'hire_date'])]
class Agent extends Model {
    use HasFactory;

    // Reglas de comisión de Harthora (solo comerciales)
    public const NOVICE_PERCENTAGE = 5;   // menos de 5 años
    public const SENIOR_PERCENTAGE = 10;  // al cumplir 5 años
    public const SENIOR_FROM_YEARS = 5;
    public const RAISE_EVERY_YEARS = 3;   // cada 3 años desde que es senior...
    public const RAISE_PERCENTAGE  = 2;   // ...sube un 2 %
    public const MAX_PERCENTAGE    = 26;  // tope

    //Convertir a fecha para calcular comisiones
    protected function casts(): array{
        return [
            'hire_date' => 'date',
        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function properties(): HasMany{
        return $this->hasMany(Property::class);
    }

    public function visits(): HasMany{
        return $this->hasMany(Visit::class);
    }

    public function sales(): HasMany{
        return $this->hasMany(Sale::class);
    }

    public function validatedSales(): HasMany{
        return $this->hasMany(Sale::class, 'validated_by');
    }

    public function commissions(): HasManyThrough{
        return $this->hasManyThrough(Commission::class, Sale::class);
    }

    /* Porcentaje de comisión que le corresponde en una fecha concreta
     * (normalmente la fecha de la venta), según su antigüedad en ese momento.
     * */
    public function commissionPercentageAt(CarbonInterface $date): float{
        $years = (int) $this->hire_date->diffInYears($date);

        if ($years < self::SENIOR_FROM_YEARS) {
            return self::NOVICE_PERCENTAGE;
        }

        // Tramos completos de 3 años cumplidos desde que pasó a senior
        $raises = intdiv($years - self::SENIOR_FROM_YEARS, self::RAISE_EVERY_YEARS);

        return min(self::SENIOR_PERCENTAGE + $raises * self::RAISE_PERCENTAGE, self::MAX_PERCENTAGE);
    }
}
