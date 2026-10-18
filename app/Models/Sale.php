<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['property_id','client_id',
            'agent_id','validated_by',
            'price','payment_method',
            'status','rejection_reason',
            'resolved_at',
])]
class Sale extends Model{
    use HasFactory;

    protected function casts(): array{
        return [
            'price' => 'decimal:2',
            'resolved_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo{
        return $this->belongsTo(Property::class);
    }

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }

    public function agent(): BelongsTo{
        return $this->belongsTo(Agent::class);
    }

    public function validator(): BelongsTo{
        return $this->belongsTo(Agent::class, 'validated_by');
    }

    public function commission(): HasOne{
        return $this->hasOne(Commission::class);
    }
}
